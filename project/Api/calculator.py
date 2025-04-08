from flask import Flask, request, jsonify
import pickle
import numpy as np
import json
import os

app = Flask(__name__)

# Helper function to load a file with error handling
def load_file(file_path, mode='rb'):
    try:
        with open(file_path, mode) as file:
            if mode == 'rb':
                return pickle.load(file)
            else:
                return json.load(file)
    except FileNotFoundError:
        error_msg = f"File {file_path} not found. Please check the path."
        return jsonify({"error": error_msg}), 404
    except (json.JSONDecodeError, pickle.UnpicklingError):
        error_msg = "Error loading the file. Please ensure the file format is correct."
        return jsonify({"error": error_msg}), 500

# Load the trained model
def load_model():
    model_path = os.path.join(os.path.dirname(__file__), 'model', 'Sydney home price model.pickle')
    return load_file(model_path)

# Load JSON file for location data
def load_locations():
    locations_path = os.path.join(os.path.dirname(__file__), 'model', 'columns.json')
    result = load_file(locations_path, 'r')
    if isinstance(result, tuple):  # Check if result is an error response
        return result
    try:
        locations = result['data_columns'][2:]  # Extract location names
        return locations
    except KeyError:
        return jsonify({"error": "Invalid JSON file format."}), 500

# Load model and locations
model = load_model()
locations = load_locations()

# Prediction function
def predict_price(bedrooms, bathrooms, location):
    if isinstance(locations, tuple):  # Check if locations loading failed
        return locations

    loc_index = locations.index(location) + 2 if location in locations else -1
    if loc_index == -1:
        return jsonify({"error": "Location not found in the dataset."}), 400

    x_new = np.zeros(len(locations) + 2)  # +2 for bedrooms and bathrooms
    x_new[0] = bedrooms
    x_new[1] = bathrooms
    if loc_index != -1:
        x_new[loc_index] = 1

    try:
        past_predicted_price = model.predict([x_new])[0]
        prediction = past_predicted_price + (0.1 * past_predicted_price)
        return prediction
    except Exception as e:
        return jsonify({"error": f"Prediction error: {e}"}), 500

# Flask route for predictions
@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    bedrooms = data.get('bedrooms')
    bathrooms = data.get('bathrooms')
    location = data.get('location')

    if not all([bedrooms, bathrooms, location]):
        return jsonify({"error": "Missing required fields (bedrooms, bathrooms, location)."}), 400

    prediction = predict_price(bedrooms, bathrooms, location)
    if isinstance(prediction, float):  # Check if prediction is successful
        return jsonify({"predicted_price": prediction})
    else:
        return prediction  # Return the error response from predict_price

if __name__ == '__main__':
    app.run(debug=True)
