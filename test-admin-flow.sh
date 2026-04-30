#!/bin/bash

echo "=== STEP 1: Get login page & CSRF token ==="
TOKEN=$(curl -s http://localhost:8000/login | grep -o 'name="csrf-token" content="[^"]*' | cut -d'"' -f4)
echo "CSRF Token: $TOKEN"

echo -e "\n=== STEP 2: Login as admin ==="
curl -s -c /tmp/cookies.txt -d "email=admin@gmail.com&password=password&_token=$TOKEN" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  http://localhost:8000/login -L > /dev/null

echo "Cookies saved"

echo -e "\n=== STEP 3: Access /admin/books (should show login check) ==="
curl -s -b /tmp/cookies.txt http://localhost:8000/admin/books | grep -o "<title>.*</title>"

echo -e "\n=== STEP 4: Test API with session cookie ==="
BOOKS=$(curl -s -b /tmp/cookies.txt http://localhost:8000/api/books | jq '.total, (.data | length)')
echo "API Response: $BOOKS books"

echo -e "\n=== STEP 5: Check cookie content ==="
cat /tmp/cookies.txt | head -5

