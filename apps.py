from flask import Flask, render_template, request
import pandas as pd
import numpy as np
import requests
from sklearn.ensemble import GradientBoostingRegressor
from sklearn.model_selection import train_test_split
from sklearn.metrics import mean_squared_error
import matplotlib.pyplot as plt
import io
import os

app = Flask(__name__)

# URL of the web data source
data_url = "https://nyc3.digitaloceanspaces.com/owid-public/data/co2/owid-co2-data.csv"

# Fetching the CSV data from the web
response = requests.get(data_url)
df = pd.read_csv(io.StringIO(response.text))

# Defining a default tax rate for all countries
default_tax_rate = 0.01

@app.route("/")
def index():
    return render_template("index.php")

@app.route("/calculate_tax", methods=["POST"])
def calculate_tax():
    # Getting user inputs from the form
    countries_input = request.form["countries"]
    selected_countries = [country.strip().lower() for country in countries_input.split(",")]
    selected_year = int(request.form["year"])

    # Creating a random tax matrix based on the number of selected countries
    random_tax_matrix = pd.DataFrame(
        np.random.uniform(low=0.01, high=0.03, size=(len(selected_countries), 3)),
        columns=["Category1", "Category2", "Category3"],
        index=selected_countries
    )

    # Creating an empty DataFrame to store the final results
    final_df = pd.DataFrame(columns=["country", "year", "value", "tax", "forecast"])

    # Create a figure for the plot
    plt.figure()

    # Iterating over selected countries
    for country in selected_countries:
        # Filtering the DataFrame for the specific country and year
        country_df = df[
            (df["country"].str.lower() == country)
            & (df["year"] <= selected_year)  # Use the selected year
        ]

        # Fill NaN values with the mean of the column
        country_df["co2_including_luc"] = country_df["co2_including_luc"].fillna(country_df["co2_including_luc"].mean())

        # Getting the emission value for the country in the selected year
        emission_value = country_df.loc[country_df["year"] == selected_year, "co2_including_luc"].values[0]

        # Using the random tax matrix to calculate tax
        country_tax = random_tax_matrix.loc[country, :] * emission_value

        # Forecasting future emissions
        if len(country_df["year"].values.reshape(-1, 1)) > 1 and len(country_df["co2_including_luc"].values) > 1:
            X_train, X_test, y_train, y_test = train_test_split(country_df["year"].values.reshape(-1, 1), country_df["co2_including_luc"].values, test_size=0.2, random_state=42)

            # Try a different model
            model = GradientBoostingRegressor(n_estimators=100, learning_rate=0.1, max_depth=1, random_state=42, loss='squared_error')
            model.fit(X_train, y_train)

            future_year = np.array([selected_year + 1]).reshape(-1, 1)
            future_emissions = model.predict(future_year)
        else:
            future_emissions = [emission_value]  # Use the current emissions value if there's not enough data to make a forecast

        # Appending the result to the final DataFrame
        final_df = pd.concat(
            [
                final_df,
                pd.DataFrame(
                    {
                        "country": [country],
                        "year": [selected_year],
                        "value": [emission_value],
                        "tax": [country_tax.sum()],
                        "forecast": future_emissions[0],
                    }
                ),
            ],
            ignore_index=True,
        )

        # Plotting the past trends on the same graph
        plt.plot(country_df["year"], country_df["co2_including_luc"], label=f"{country}")

    # Setting labels, title, and legend for the graph
    plt.xlabel("Year")
    plt.ylabel("Emissions")
    plt.title("Emissions Trend for Selected Countries")
    plt.legend()

    # Save the plot in the static/imgs directory with a unique name
    graph_filename = f"static/imgs/forecast_{selected_year}.png"
    plt.savefig(graph_filename)
    print("Graph saved at:", os.path.abspath(graph_filename))

    # Rendering the result in a new template
    return render_template("result.php", results=final_df.to_dict(orient='records'), graph=graph_filename)

if __name__ == "__main__":
    app.run(debug=True, port=5004)
