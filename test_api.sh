  #!/bin/bash

# Test script for Laravel API endpoints
BASE_URL="http://localhost:8000/api"

echo "Testing Laravel API endpoints..."

# Test 1: Login API
echo "1. Testing Login API..."
LOGIN_RESPONSE=$(curl -s -X POST "$BASE_URL/login" \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"pastibisa"}')

echo "Login Response: $LOGIN_RESPONSE"

# Extract token from response (assuming JSON format)
TOKEN=$(echo $LOGIN_RESPONSE | grep -o '"token":"[^"]*' | cut -d'"' -f4)

if [ -z "$TOKEN" ]; then
    echo "Login failed - no token received"
    exit 1
fi

echo "Token: $TOKEN"

# Test 2: Get Divisions API
echo "2. Testing Get Divisions API..."
DIVISIONS_RESPONSE=$(curl -s -X GET "$BASE_URL/divisions" \
  -H "Authorization: Bearer $TOKEN")

echo "Divisions Response: $DIVISIONS_RESPONSE"

# Test 3: Get Employees API
echo "3. Testing Get Employees API..."
EMPLOYEES_RESPONSE=$(curl -s -X GET "$BASE_URL/employees" \
  -H "Authorization: Bearer $TOKEN")

echo "Employees Response: $EMPLOYEES_RESPONSE"

# Test 4: Create Employee API
echo "4. Testing Create Employee API..."
CREATE_RESPONSE=$(curl -s -X POST "$BASE_URL/employees" \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"image":"https://example.com/photo.jpg","name":"John Doe","phone":"081234567890","division":"","position":"Developer"}')

echo "Create Employee Response: $CREATE_RESPONSE"

# Test 5: Logout API
echo "5. Testing Logout API..."
LOGOUT_RESPONSE=$(curl -s -X POST "$BASE_URL/logout" \
  -H "Authorization: Bearer $TOKEN")

echo "Logout Response: $LOGOUT_RESPONSE"

echo "All API tests completed!"
