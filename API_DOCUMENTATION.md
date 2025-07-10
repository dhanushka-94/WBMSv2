# 📱 Water Billing Management System - Mobile API Documentation

## 🌐 API Overview

**Base URL:** `https://your-domain.com/api/v1`  
**API Version:** v1.0.0  
**Authentication:** Laravel Sanctum (Bearer Token)  
**Content-Type:** `application/json`  
**Accept:** `application/json`

---

## 📋 Table of Contents

1. [Authentication](#authentication)
2. [Error Handling](#error-handling)
3. [Rate Limiting](#rate-limiting)
4. [Authentication Endpoints](#authentication-endpoints)
5. [Meter Reading Endpoints](#meter-reading-endpoints)
6. [Utility Endpoints](#utility-endpoints)
7. [Data Models](#data-models)
8. [Code Examples](#code-examples)

---

## 🔐 Authentication

### Token-Based Authentication
All protected endpoints require a Bearer token in the Authorization header:

```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

### Headers Required
```http
Content-Type: application/json
Accept: application/json
Authorization: Bearer YOUR_ACCESS_TOKEN
```

---

## ⚠️ Error Handling

### Standard Error Response Format
```json
{
  "success": false,
  "message": "Error description",
  "error": "Detailed error message",
  "errors": {
    "field_name": ["Validation error message"]
  }
}
```

### HTTP Status Codes
| Code | Meaning |
|------|---------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 422 | Validation Error |
| 500 | Internal Server Error |

---

## 🚫 Rate Limiting

- **Rate Limit:** 60 requests per minute per IP
- **Headers:** `X-RateLimit-Limit`, `X-RateLimit-Remaining`

---

## 🔑 Authentication Endpoints

### 1. Mobile Login

**POST** `/api/v1/login`

Login for meter readers with device registration.

#### Request Body
```json
{
  "email": "user@example.com",
  "password": "your_password",
  "device_name": "John's Phone - Android 13",
  "device_info": {
    "platform": "android",
    "version": "13",
    "model": "Samsung Galaxy S21",
    "app_version": "1.0.0"
  }
}
```

#### Response (Success - 200)
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "token": "1|eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "user@example.com",
      "role": "meter_reader",
      "permissions": {
        "can_read_meters": true,
        "can_view_customer_details": true,
        "can_take_photos": true,
        "can_add_notes": true,
        "can_view_history": false,
        "can_edit_readings": false,
        "can_generate_reports": false
      }
    },
    "app_config": {
      "app_version": "1.0.0",
      "api_version": "v1",
      "features": {
        "offline_mode": true,
        "photo_capture": true,
        "gps_tracking": true,
        "barcode_scanning": false,
        "receipt_printing": true,
        "auto_sync": true
      },
      "settings": {
        "max_photo_size": 5120,
        "auto_sync_interval": 300,
        "offline_storage_limit": 1000,
        "gps_accuracy_threshold": 10
      },
      "server_info": {
        "timezone": "Asia/Colombo",
        "datetime_format": "Y-m-d H:i:s",
        "currency": "LKR"
      }
    },
    "expires_at": "2024-02-10T15:30:00.000Z"
  }
}
```

#### Response (Error - 401)
```json
{
  "success": false,
  "message": "Invalid credentials"
}
```

### 2. Mobile Logout

**POST** `/api/v1/logout`

Logout and revoke current token.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

### 3. Refresh Token

**POST** `/api/v1/refresh`

Refresh the current authentication token.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "message": "Token refreshed successfully",
  "data": {
    "token": "2|newTokenString...",
    "expires_at": "2024-02-10T15:30:00.000Z"
  }
}
```

### 4. Check Token Validity

**GET** `/api/v1/check-token`

Verify if the current token is valid.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "message": "Token is valid",
  "data": {
    "user_id": 1,
    "token_name": "John's Phone - Android 13",
    "abilities": ["meter-reading"],
    "last_used_at": "2024-01-10T14:30:00.000Z",
    "expires_at": "2024-02-10T15:30:00.000Z"
  }
}
```

### 5. Get User Profile

**GET** `/api/v1/profile`

Get current user profile information.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "user@example.com",
      "role": "meter_reader",
      "permissions": {
        "can_read_meters": true,
        "can_view_customer_details": true,
        "can_take_photos": true,
        "can_add_notes": true,
        "can_view_history": false,
        "can_edit_readings": false,
        "can_generate_reports": false
      },
      "last_login": "2024-01-10T08:30:00.000Z",
      "created_at": "2023-06-15T10:00:00.000Z"
    },
    "app_config": {
      "app_version": "1.0.0",
      "api_version": "v1",
      "features": {
        "offline_mode": true,
        "photo_capture": true,
        "gps_tracking": true,
        "receipt_printing": true,
        "auto_sync": true
      }
    }
  }
}
```

### 6. Update Profile

**PUT** `/api/v1/profile`

Update user profile (limited fields for mobile).

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Request Body
```json
{
  "name": "John Smith",
  "phone": "+94771234567",
  "current_password": "current_password",
  "new_password": "new_password",
  "new_password_confirmation": "new_password"
}
```

#### Response (Success - 200)
```json
{
  "success": true,
  "message": "Profile updated successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Smith",
      "email": "user@example.com",
      "phone": "+94771234567",
      "role": "meter_reader"
    }
  }
}
```

---

## 📊 Meter Reading Endpoints

### 1. Get Today's Route

**GET** `/api/v1/meter-reading/route/today`

Get customers assigned for today's meter reading route.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Query Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| area | string | No | Filter by specific area |
| route | string | No | Filter by specific route |

#### Example Request
```http
GET /api/v1/meter-reading/route/today?area=Colombo&route=R001
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": {
    "customers": [
      {
        "id": 1,
        "connection_number": "CN001",
        "name": "Alice Johnson",
        "address": "123 Main Street, Colombo 07",
        "phone": "+94771234567",
        "area": "Colombo",
        "route": "R001",
        "meter": {
          "id": 1,
          "meter_number": "MT001",
          "type": "cumulative",
          "current_reading": 1250.75,
          "status": "active",
          "location_description": "Front garden near gate",
          "gps_latitude": 6.9271,
          "gps_longitude": 79.8612
        },
        "last_reading": {
          "reading": 1200.50,
          "date": "2024-01-01",
          "reader": "Previous Reader"
        },
        "status": "active",
        "billing_status": "current",
        "last_sync": "2024-01-10T09:00:00.000Z"
      }
    ],
    "total_count": 25,
    "route_info": {
      "area": "Colombo",
      "route": "R001",
      "date": "2024-01-10",
      "reader": "John Doe"
    }
  },
  "timestamp": "2024-01-10T09:00:00.000Z"
}
```

### 2. Submit Meter Reading

**POST** `/api/v1/meter-reading/submit`

Submit a new meter reading.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
Content-Type: multipart/form-data
```

#### Request Body (multipart/form-data)
```javascript
// Form data fields
{
  customer_id: 1,
  meter_id: 1,
  current_reading: 1275.25,
  reading_date: "2024-01-10",
  gps_latitude: 6.9271,
  gps_longitude: 79.8612,
  meter_photo: [File object], // Optional image file
  notes: "Meter in good condition",
  meter_condition: "good", // good|damaged|broken|needs_repair
  reading_accuracy: "exact", // exact|estimated|calculated
  offline_timestamp: "2024-01-10T10:30:00.000Z" // For offline readings
}
```

#### Response (Success - 200)
```json
{
  "success": true,
  "message": "Meter reading submitted successfully",
  "data": {
    "reading_id": 123,
    "customer": {
      "name": "Alice Johnson",
      "connection_number": "CN001",
      "address": "123 Main Street, Colombo 07"
    },
    "meter": {
      "meter_number": "MT001",
      "previous_reading": 1250.75,
      "current_reading": 1275.25,
      "consumption": 24.50
    },
    "reading_details": {
      "date": "2024-01-10",
      "reader": "John Doe",
      "condition": "good",
      "accuracy": "exact",
      "notes": "Meter in good condition"
    },
    "receipt_data": {
      "receipt_number": "MR-000123",
      "date": "2024-01-10",
      "time": "10:30:00",
      "customer": {
        "name": "Alice Johnson",
        "connection_number": "CN001",
        "address": "123 Main Street, Colombo 07",
        "phone": "+94771234567"
      },
      "meter": {
        "meter_number": "MT001",
        "type": "cumulative",
        "location": "Front garden near gate"
      },
      "reading": {
        "previous": 1250.75,
        "current": 1275.25,
        "consumption": 24.50,
        "units": "cubic meters"
      },
      "reader": {
        "name": "John Doe",
        "signature_line": "________________________"
      },
      "footer": {
        "company": "Water Billing Management System",
        "note": "Thank you for your cooperation",
        "website": "www.waterbilling.com"
      }
    },
    "sync_status": "completed",
    "timestamp": "2024-01-10T10:30:00.000Z"
  }
}
```

#### Response (Error - 422)
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "current_reading": ["The current reading field is required."],
    "customer_id": ["The selected customer id is invalid."]
  }
}
```

#### Response (Error - 400)
```json
{
  "success": false,
  "message": "Reading cannot be less than previous reading for cumulative meters",
  "previous_reading": 1250.75,
  "submitted_reading": 1200.00
}
```

### 3. Bulk Sync Readings (Offline Mode)

**POST** `/api/v1/meter-reading/bulk-sync`

Synchronize multiple readings saved offline.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Request Body
```json
{
  "readings": [
    {
      "customer_id": 1,
      "meter_id": 1,
      "current_reading": 1275.25,
      "reading_date": "2024-01-10",
      "offline_timestamp": "2024-01-10T10:30:00.000Z",
      "gps_latitude": 6.9271,
      "gps_longitude": 79.8612,
      "notes": "First reading",
      "meter_condition": "good",
      "reading_accuracy": "exact"
    },
    {
      "customer_id": 2,
      "meter_id": 2,
      "current_reading": 890.50,
      "reading_date": "2024-01-10",
      "offline_timestamp": "2024-01-10T11:00:00.000Z",
      "notes": "Second reading"
    }
  ]
}
```

#### Response (Success - 200)
```json
{
  "success": true,
  "message": "Bulk sync completed: 2 successful, 0 failed",
  "data": {
    "results": [
      {
        "index": 0,
        "status": "success",
        "data": {
          "reading_id": 123,
          "customer": {
            "name": "Alice Johnson"
          }
        }
      },
      {
        "index": 1,
        "status": "success",
        "data": {
          "reading_id": 124,
          "customer": {
            "name": "Bob Smith"
          }
        }
      }
    ],
    "summary": {
      "total": 2,
      "successful": 2,
      "failed": 0
    }
  }
}
```

### 4. Get Customer Details

**GET** `/api/v1/meter-reading/customers/{customerId}`

Get detailed information about a specific customer.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Path Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| customerId | integer | Yes | Customer ID |

#### Example Request
```http
GET /api/v1/meter-reading/customers/1
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": {
    "customer": {
      "id": 1,
      "connection_number": "CN001",
      "name": "Alice Johnson",
      "address": "123 Main Street, Colombo 07",
      "phone": "+94771234567",
      "email": "alice@example.com",
      "area": "Colombo",
      "route": "R001",
      "status": "active",
      "billing_status": "current"
    },
    "meter": {
      "id": 1,
      "meter_number": "MT001",
      "type": "cumulative",
      "current_reading": 1250.75,
      "status": "active",
      "installation_date": "2020-01-15",
      "location_description": "Front garden near gate",
      "gps_latitude": 6.9271,
      "gps_longitude": 79.8612
    },
    "recent_readings": [
      {
        "id": 120,
        "reading": 1250.75,
        "consumption": 45.25,
        "date": "2024-01-01",
        "reader": "Previous Reader",
        "condition": "good",
        "photo_available": true
      },
      {
        "id": 119,
        "reading": 1205.50,
        "consumption": 38.75,
        "date": "2023-12-01",
        "reader": "Previous Reader",
        "condition": "good",
        "photo_available": false
      }
    ]
  }
}
```

### 5. Search Customers

**GET** `/api/v1/meter-reading/customers/search`

Search for customers by various criteria.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Query Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| q | string | Yes | Search query (min 2 characters) |
| limit | integer | No | Max results (default: 20, max: 50) |

#### Example Request
```http
GET /api/v1/meter-reading/customers/search?q=alice&limit=10
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": {
    "customers": [
      {
        "id": 1,
        "connection_number": "CN001",
        "name": "Alice Johnson",
        "address": "123 Main Street, Colombo 07",
        "phone": "+94771234567",
        "area": "Colombo",
        "meter_number": "MT001",
        "current_reading": 1250.75
      }
    ],
    "count": 1,
    "query": "alice"
  }
}
```

### 6. Get Meter Reading History

**GET** `/api/v1/meter-reading/customers/{customerId}/history`

Get meter reading history for a specific customer.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Path Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| customerId | integer | Yes | Customer ID |

#### Example Request
```http
GET /api/v1/meter-reading/customers/1/history
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": {
    "customer_name": "Alice Johnson",
    "connection_number": "CN001",
    "readings": [
      {
        "id": 123,
        "reading_date": "2024-01-10",
        "previous_reading": 1250.75,
        "current_reading": 1275.25,
        "consumption": 24.50,
        "reader_name": "John Doe",
        "reading_type": "exact",
        "meter_condition": "good",
        "photo_available": true,
        "notes": "Meter in good condition",
        "submitted_via": "mobile_app"
      }
    ],
    "total_readings": 12
  }
}
```

### 7. Get Recent Readings

**GET** `/api/v1/meter-reading/readings/recent`

Get recent readings submitted by the current user.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": [
    {
      "id": 123,
      "customer_name": "Alice Johnson",
      "connection_number": "CN001",
      "meter_number": "MT001",
      "reading": 1275.25,
      "consumption": 24.50,
      "date": "2024-01-10",
      "status": "completed",
      "submitted_via": "mobile_app"
    }
  ]
}
```

### 8. Get Statistics

**GET** `/api/v1/meter-reading/stats`

Get reading statistics for the current user.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": {
    "today": {
      "readings_completed": 15,
      "customers_visited": 15
    },
    "this_month": {
      "total_readings": 320,
      "total_consumption": 8750.25
    },
    "performance": {
      "average_readings_per_day": 18.5,
      "accuracy_rate": 98.5
    }
  }
}
```

---

## 🛠️ Utility Endpoints

### 1. Health Check

**GET** `/api/v1/health`

Check API health status.

#### Response (Success - 200)
```json
{
  "status": "ok",
  "version": "1.0.0",
  "timestamp": "2024-01-10T12:00:00.000Z",
  "server": "Water Billing Management System API"
}
```

### 2. App Information

**GET** `/api/v1/app-info`

Get app information and features.

#### Response (Success - 200)
```json
{
  "app_name": "WBMS Mobile",
  "version": "1.0.0",
  "api_version": "v1",
  "features": {
    "offline_mode": true,
    "photo_capture": true,
    "gps_tracking": true,
    "receipt_printing": true,
    "auto_sync": true
  },
  "contact": {
    "support_email": "support@waterbilling.com",
    "website": "https://waterbilling.com"
  }
}
```

### 3. Get Areas

**GET** `/api/v1/utils/areas`

Get list of available areas.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": [
    "Colombo",
    "Kandy",
    "Galle",
    "Jaffna",
    "Negombo"
  ]
}
```

### 4. Get Routes

**GET** `/api/v1/utils/routes`

Get list of available routes.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Query Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| area | string | No | Filter routes by area |

#### Example Request
```http
GET /api/v1/utils/routes?area=Colombo
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": [
    "R001",
    "R002",
    "R003",
    "R004"
  ]
}
```

### 5. System Information

**GET** `/api/v1/utils/system-info`

Get system information.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": {
    "server_time": "2024-01-10T12:00:00.000Z",
    "timezone": "Asia/Colombo",
    "app_version": "1.0.0",
    "api_version": "v1",
    "maintenance_mode": false
  }
}
```

---

## 🔄 Sync Endpoints

### 1. Get Pending Sync Data

**GET** `/api/v1/sync/pending`

Get information about pending synchronization.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "data": {
    "pending_uploads": 0,
    "last_sync": "2024-01-10T12:00:00.000Z",
    "sync_status": "up_to_date"
  }
}
```

### 2. Force Sync

**POST** `/api/v1/sync/force`

Force a synchronization process.

#### Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
```

#### Response (Success - 200)
```json
{
  "success": true,
  "message": "Sync completed successfully",
  "data": {
    "synced_at": "2024-01-10T12:00:00.000Z",
    "items_synced": 0
  }
}
```

---

## 📋 Data Models

### Customer Model
```typescript
interface Customer {
  id: number;
  connection_number: string;
  name: string;
  address: string;
  phone: string;
  email?: string;
  area: string;
  route: string;
  status: 'active' | 'inactive' | 'suspended';
  billing_status: 'current' | 'overdue' | 'disconnected';
  meter?: WaterMeter;
  last_reading?: MeterReading;
  last_sync: string;
}
```

### Water Meter Model
```typescript
interface WaterMeter {
  id: number;
  meter_number: string;
  type: 'cumulative' | 'differential';
  current_reading: number;
  status: 'active' | 'inactive' | 'damaged';
  installation_date: string;
  location_description?: string;
  gps_latitude?: number;
  gps_longitude?: number;
}
```

### Meter Reading Model
```typescript
interface MeterReading {
  id: number;
  customer_id: number;
  water_meter_id: number;
  previous_reading: number;
  current_reading: number;
  consumption: number;
  reading_date: string;
  reader_id: number;
  reader_name: string;
  notes?: string;
  reading_type: 'exact' | 'estimated' | 'calculated';
  meter_condition: 'good' | 'damaged' | 'broken' | 'needs_repair';
  photo_path?: string;
  gps_latitude?: number;
  gps_longitude?: number;
  submitted_via: 'mobile_app' | 'web_app' | 'manual';
  offline_timestamp?: string;
  created_at: string;
  updated_at: string;
}
```

### User Model
```typescript
interface User {
  id: number;
  name: string;
  email: string;
  role: 'admin' | 'meter_reader' | 'supervisor' | 'accountant';
  permissions: {
    can_read_meters: boolean;
    can_view_customer_details: boolean;
    can_take_photos: boolean;
    can_add_notes: boolean;
    can_view_history: boolean;
    can_edit_readings: boolean;
    can_generate_reports: boolean;
  };
  last_login?: string;
  created_at: string;
}
```

---

## 💻 Code Examples

### JavaScript/React Native Example

```javascript
// API Client Setup
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

const API_BASE_URL = 'https://your-domain.com/api/v1';

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Add auth token to requests
apiClient.interceptors.request.use(async (config) => {
  const token = await AsyncStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Login function
const login = async (email, password, deviceName) => {
  try {
    const response = await apiClient.post('/login', {
      email,
      password,
      device_name: deviceName,
      device_info: {
        platform: Platform.OS,
        version: Platform.Version,
        model: DeviceInfo.getModel(),
        app_version: '1.0.0'
      }
    });
    
    if (response.data.success) {
      await AsyncStorage.setItem('auth_token', response.data.data.token);
      await AsyncStorage.setItem('user_data', JSON.stringify(response.data.data.user));
      return response.data;
    }
    
    throw new Error(response.data.message);
  } catch (error) {
    throw error;
  }
};

// Get today's route
const getTodaysRoute = async (area = null, route = null) => {
  try {
    const params = {};
    if (area) params.area = area;
    if (route) params.route = route;
    
    const response = await apiClient.get('/meter-reading/route/today', { params });
    return response.data;
  } catch (error) {
    throw error;
  }
};

// Submit meter reading
const submitReading = async (readingData) => {
  try {
    const formData = new FormData();
    
    // Add form fields
    Object.keys(readingData).forEach(key => {
      if (key === 'meter_photo' && readingData[key]) {
        formData.append('meter_photo', {
          uri: readingData[key].uri,
          type: readingData[key].type || 'image/jpeg',
          name: readingData[key].fileName || 'meter_photo.jpg'
        });
      } else if (readingData[key] !== null && readingData[key] !== undefined) {
        formData.append(key, readingData[key].toString());
      }
    });
    
    const response = await apiClient.post('/meter-reading/submit', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
    
    return response.data;
  } catch (error) {
    throw error;
  }
};

// Bulk sync offline readings
const bulkSyncReadings = async (readings) => {
  try {
    const response = await apiClient.post('/meter-reading/bulk-sync', {
      readings
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};

// Get customer details
const getCustomerDetails = async (customerId) => {
  try {
    const response = await apiClient.get(`/meter-reading/customers/${customerId}`);
    return response.data;
  } catch (error) {
    throw error;
  }
};

// Search customers
const searchCustomers = async (query, limit = 20) => {
  try {
    const response = await apiClient.get('/meter-reading/customers/search', {
      params: { q: query, limit }
    });
    return response.data;
  } catch (error) {
    throw error;
  }
};

// Error handling wrapper
const handleApiError = (error) => {
  if (error.response) {
    // Server responded with error status
    const { status, data } = error.response;
    
    switch (status) {
      case 401:
        // Unauthorized - redirect to login
        AsyncStorage.removeItem('auth_token');
        AsyncStorage.removeItem('user_data');
        // Navigate to login screen
        break;
      case 422:
        // Validation errors
        return {
          success: false,
          message: 'Validation failed',
          errors: data.errors
        };
      case 500:
        return {
          success: false,
          message: 'Server error. Please try again later.'
        };
      default:
        return {
          success: false,
          message: data.message || 'An error occurred'
        };
    }
  } else if (error.request) {
    // Network error
    return {
      success: false,
      message: 'Network error. Please check your connection.'
    };
  } else {
    return {
      success: false,
      message: error.message || 'An unexpected error occurred'
    };
  }
};

export {
  login,
  getTodaysRoute,
  submitReading,
  bulkSyncReadings,
  getCustomerDetails,
  searchCustomers,
  handleApiError
};
```

### cURL Examples

```bash
# Login
curl -X POST "https://your-domain.com/api/v1/login" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "your_password",
    "device_name": "Test Device"
  }'

# Get today's route
curl -X GET "https://your-domain.com/api/v1/meter-reading/route/today" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"

# Submit reading
curl -X POST "https://your-domain.com/api/v1/meter-reading/submit" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "customer_id": 1,
    "meter_id": 1,
    "current_reading": 1275.25,
    "reading_date": "2024-01-10",
    "meter_condition": "good",
    "reading_accuracy": "exact"
  }'

# Get customer details
curl -X GET "https://your-domain.com/api/v1/meter-reading/customers/1" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

---

## 🔧 Testing

### Postman Collection
You can import the following Postman collection for testing:

```json
{
  "info": {
    "name": "WBMS Mobile API",
    "description": "Water Billing Management System Mobile API"
  },
  "variable": [
    {
      "key": "base_url",
      "value": "https://your-domain.com/api/v1"
    },
    {
      "key": "token",
      "value": ""
    }
  ],
  "auth": {
    "type": "bearer",
    "bearer": [
      {
        "key": "token",
        "value": "{{token}}",
        "type": "string"
      }
    ]
  }
}
```

### Environment Variables
Set up these environment variables for testing:

- `base_url`: Your API base URL
- `test_email`: Test user email
- `test_password`: Test user password
- `token`: Authentication token (auto-set after login)

---

## 📞 Support

For API support and questions:

- **Email:** support@waterbilling.com
- **Documentation:** https://waterbilling.com/docs/api
- **Status Page:** https://status.waterbilling.com

---

## 👨‍💻 Developer Credits

**System Developed By:**  
**Olexto Digital Solutions (Pvt) Ltd**

*Professional software development and digital transformation solutions*

- **Website:** [www.olexto.com](https://www.olexto.com)
- **Email:** info@olexto.com
- **Specializations:** Enterprise Software, Mobile Applications, API Development, Digital Solutions

---

## 📄 License

This API documentation is proprietary to the Water Billing Management System.

---

**Last Updated:** January 10, 2024  
**API Version:** v1.0.0  
**Developed By:** Olexto Digital Solutions (Pvt) Ltd 