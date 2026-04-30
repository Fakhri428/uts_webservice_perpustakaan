#!/bin/bash

# Test API with session authentication
BASE_URL="http://localhost:8000"
COOKIES="/tmp/cookies.txt"

echo "====== Testing Session Authentication ======"
echo ""

# Step 1: Get CSRF token from login page
echo "Step 1: Getting CSRF token from login page..."
CSRF_TOKEN=$(curl -s -c "$COOKIES" "$BASE_URL/login" | grep -oP 'name="csrf_token" value="\K[^"]+' | head -1)
if [ -z "$CSRF_TOKEN" ]; then
    CSRF_TOKEN=$(curl -s -c "$COOKIES" "$BASE_URL/login" | grep -oP 'csrf-token.*?content="\K[^"]+' | head -1)
fi

echo "CSRF Token: ${CSRF_TOKEN:0:20}..."
echo ""

# Step 2: Login as user
echo "Step 2: Logging in as user@gmail.com..."
LOGIN_RESPONSE=$(curl -s -b "$COOKIES" -c "$COOKIES" -X POST "$BASE_URL/login" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "X-CSRF-Token: $CSRF_TOKEN" \
  -d "email=user@gmail.com&password=password&remember=on")

if echo "$LOGIN_RESPONSE" | grep -q "redirect"; then
    echo "✓ Login successful"
else
    echo "✗ Login may have failed (checking redirects...)"
fi
echo ""

# Step 3: Test GET /api/books (public, no auth needed)
echo "Step 3: Testing GET /api/books (public endpoint)..."
BOOKS=$(curl -s -b "$COOKIES" "$BASE_URL/api/books" | jq '.total' 2>/dev/null)
if [ ! -z "$BOOKS" ]; then
    echo "✓ Books endpoint works: $BOOKS books found"
else
    echo "✗ Books endpoint failed"
fi
echo ""

# Step 4: Test GET /api/loans (requires auth)
echo "Step 4: Testing GET /api/loans (authenticated endpoint)..."
LOANS_RESPONSE=$(curl -s -b "$COOKIES" "$BASE_URL/api/loans")
if echo "$LOANS_RESPONSE" | grep -q '"data"'; then
    LOANS_COUNT=$(echo "$LOANS_RESPONSE" | jq '.total' 2>/dev/null || echo "?")
    echo "✓ Loans endpoint works: $LOANS_COUNT loans found"
    echo "Sample response: $(echo "$LOANS_RESPONSE" | jq '.' | head -20)"
elif echo "$LOANS_RESPONSE" | grep -q "Unauthenticated"; then
    echo "✗ Still unauthenticated - session not working"
    echo "Response: $LOANS_RESPONSE"
else
    echo "Response: $LOANS_RESPONSE"
fi
echo ""

echo "====== Test Complete ======"
