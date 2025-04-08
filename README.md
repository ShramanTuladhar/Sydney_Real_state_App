# 🏠 Sydney Real Estate Website

A dynamic web application that showcases Sydney property listings, integrates interactive maps, and provides intelligent house price predictions using a machine learning model. Built as part of a Capstone Project for our Data Science program.

---

## 🚀 Features

### 🌐 Front-End Features
- **User-Friendly Interface**: Intuitive design with easy navigation and responsive layout.
- **Map Integration**: Visualize property listings on an interactive map using Leaflet.js.
- **Search and Filter**: Filter properties based on suburb, property type, number of bedrooms, bathrooms, and car spaces.
- **Property Details**: Clickable map markers to view detailed info (price, features, etc.) for each listing.
- **Real-Time Price Prediction**: Integrated ML model predicts house prices based on user-inputted features.

### 🧠 Machine Learning Integration
- **Model Tested**: Random Forest Regressor. Lasso regression, Linear regression
- **Model used**: Linear Regression
- **Input Features**: Suburb, Property Type, Number of Bedrooms, Bathrooms, Car Spaces, and Distance to CBD.
- **Output**: Estimated market value of the property in AUD.
- **Accuracy**: Achieved an R² score of ~0.91 on the test set.

---

## 🏗️ Tech Stack

| Component       | Technology Used                  |
|----------------|----------------------------------|
| Frontend       | HTML, CSS, JavaScript|
| Backend        | Python, Flask, Php                    |
| Machine Learning | scikit-learn, pandas, numpy    |
| Database       | MySQL                            |
| Deployment     | Localhost (can be extended to cloud platforms) |

---


## 📊 Dataset

- **Source**: Cleaned and processed dataset of Sydney house sales from **kaggle.com**
- **Size**: ~200,000 property listings 
- **Preprocessing Steps**:
  - Removal of outliers and missing values
  - Categorical encoding for suburbs and property types
  - Feature scaling for continuous variables

---

## ⚙️ Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/sydney-realestate-website.git
   cd sydney-realestate-website
   ```

2. **Create a Virtual Environment**
   ```bash
   python -m venv venv
   source venv/bin/activate  # On Windows: venv\Scripts\activate
   ```

3. **Install Dependencies**
   ```bash
   pip install -r requirements.txt
   ```

4. **Run the Application**
   ```bash
   python app.py
   ```

5. **View in Browser**
   Open `http://127.0.0.1:5000/` in your web browser.

---

## 🧪 Demo Screenshots

> 📸 *Add screenshots here showing your map, property filter, and prediction interface*

---

## 📌 Future Improvements

- Deploy to cloud platforms like AWS or Heroku
- Add user authentication and profile management
- Use live data from property APIs for real-time updates
- Incorporate satellite images or air/noise quality indicators

---

## 👨‍💻 Authors

- **Group 1 - Capstone Project, Data Science Program**
- Team Members: *Shraman Ratna Tuladhar*
                *Amish Poudel*

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).
