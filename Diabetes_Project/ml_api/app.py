from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split, cross_val_score
from sklearn.preprocessing import StandardScaler
from sklearn.linear_model import LogisticRegression
from sklearn.ensemble import RandomForestClassifier
from sklearn.svm import SVC
from sklearn.neighbors import KNeighborsClassifier
from sklearn.tree import DecisionTreeClassifier
import joblib

app = Flask(__name__)

# load dataset local or remote
df = pd.read_csv('diabetes.csv')
X = df.drop('Outcome', axis=1)
y = df['Outcome']

scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

models = {
    "Logistic Regression": LogisticRegression(max_iter=2000),
    "Random Forest": RandomForestClassifier(n_estimators=100),
    "SVM": SVC(probability=True),
    "KNN": KNeighborsClassifier(),
    "Decision Tree": DecisionTreeClassifier()
}

accuracies = {}
# train once using cross validation for more stable metrics
for name, m in models.items():
    scores = cross_val_score(m, X_scaled, y, cv=5)
    accuracies[name] = round(scores.mean()*100,2)
    # fit on full scaled data for prediction
    m.fit(X_scaled, y)

# keep scaler and models in memory
@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    # expected fields; default 0 for pregnancies
    vals = [data.get('Pregnancies',0),
            data.get('Glucose',0),
            data.get('BloodPressure',0),
            data.get('SkinThickness',0),
            data.get('Insulin',0),
            data.get('BMI',0),
            data.get('DiabetesPedigreeFunction',0),
            data.get('Age',0)]
    arr = np.array(vals).reshape(1,-1)
    # transform using fitted scaler (fit on full dataset)
    arr_scaled = scaler.transform(arr)
    selected = data.get('models', None)  # optional list
    predictions = {}
    for name, m in models.items():
        if selected and name not in selected:
            continue
        pred = m.predict(arr_scaled)[0]
        predictions[name] = "Diabetic" if int(pred)==1 else "Non-Diabetic"

    return jsonify({
        "predictions": predictions,
        "accuracies": {k:accuracies[k] for k in predictions.keys()}
    })

if __name__ == '__main__':
    app.run(debug=True)
