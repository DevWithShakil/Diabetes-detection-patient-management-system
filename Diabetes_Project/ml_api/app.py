from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
from sklearn.preprocessing import StandardScaler
from sklearn.linear_model import LogisticRegression
from sklearn.ensemble import RandomForestClassifier
from sklearn.svm import SVC
from sklearn.neighbors import KNeighborsClassifier
from sklearn.tree import DecisionTreeClassifier

app = Flask(__name__)

# 1. Load Dataset
try:
    df = pd.read_csv('diabetes.csv')
    X = df.drop('Outcome', axis=1)
    y = df['Outcome']
except:
    # Safety fallback if CSV is missing
    print("Dataset not found! Creating dummy data...")
    X = pd.DataFrame(np.random.rand(100, 8), columns=['Pregnancies','Glucose','BloodPressure','SkinThickness','Insulin','BMI','DiabetesPedigreeFunction','Age'])
    y = pd.Series(np.random.randint(0, 2, 100))

# 2. Preprocessing (Scaling is crucial for SVM & KNN)
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# 3. Optimized Models (Hyperparameter Tuning)
models = {
    # Logistic Regression: Increased max_iter for better convergence
    "Logistic Regression": LogisticRegression(max_iter=1000, C=1.0, solver='lbfgs'),
    
    # Random Forest: More trees (200) and depth limit to prevent overfitting
    "Random Forest": RandomForestClassifier(n_estimators=200, max_depth=10, random_state=42),
    
    # SVM: Radial basis function (rbf) kernel usually works best for this data
    "SVM": SVC(probability=True, kernel='rbf', C=1.0, gamma='scale', random_state=42),
    
    # KNN: 9 Neighbors usually reduces noise better than 5 for this dataset
    "KNN": KNeighborsClassifier(n_neighbors=9, weights='distance'),
    
    # Decision Tree: Pruned depth to generalize better
    "Decision Tree": DecisionTreeClassifier(max_depth=5, criterion='entropy', random_state=42)
}

# 4. Train Models
print("Training optimized models...")
for name, m in models.items():
    m.fit(X_scaled, y)
print("Training complete.")

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    
    # Get Input Data (Defaulting 0 if missing)
    vals = [
        data.get('Pregnancies', 0),
        float(data.get('Glucose', 0)),
        float(data.get('BloodPressure', 0)),
        float(data.get('SkinThickness', 0)),
        float(data.get('Insulin', 0)),
        float(data.get('BMI', 0)),
        float(data.get('DiabetesPedigreeFunction', 0)),
        float(data.get('Age', 0))
    ]
    
    # Reshape and Scale Input
    arr = np.array(vals).reshape(1, -1)
    arr_scaled = scaler.transform(arr)
    
    predictions = {}
    accuracies = {}
    
    for name, m in models.items():
        # Prediction
        pred = m.predict(arr_scaled)[0]
        predictions[name] = "Diabetic" if int(pred) == 1 else "Non-Diabetic"
        
        # Real Confidence Score Logic
        if hasattr(m, "predict_proba"):
            proba = m.predict_proba(arr_scaled)[0]
            confidence = np.max(proba) * 100
            accuracies[name] = round(confidence, 2)
        else:
            accuracies[name] = 0

    return jsonify({
        "status": "Success",
        "predictions": predictions,
        "accuracies": accuracies
    })

if __name__ == '__main__':
    app.run(debug=True, port=5000)