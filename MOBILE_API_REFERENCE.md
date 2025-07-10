# 📱 DN WASSIP Mobile API - Complete Reference Guide

## 🌐 API Overview

**Base URL:** `https://erp.dunwassip.com/api/v1`  
**Local Testing:** `http://127.0.0.1:8000/api/v1`  
**API Version:** v1.0.0  
**Authentication:** Laravel Sanctum (Bearer Token)  
**Content-Type:** `application/json`  
**Accept:** `application/json`

---

## 📋 Complete Endpoint List (22 Endpoints)

### **🔐 Authentication (5 endpoints)**
- `POST /login` - Mobile login with device registration
- `POST /logout` - Logout and revoke token
- `POST /refresh` - Refresh authentication token
- `GET /check-token` - Verify token validity
- `GET /profile` - Get user profile
- `PUT /profile` - Update user profile

### **📊 Meter Reading (7 endpoints)**
- `GET /meter-reading/route/today` - Get daily route assignments
- `POST /meter-reading/submit` - Submit meter reading
- `POST /meter-reading/bulk-sync` - Bulk sync offline readings
- `GET /meter-reading/customers/search` - Search customers
- `GET /meter-reading/customers/{customerId}` - Get customer details
- `GET /meter-reading/customers/{customerId}/history` - Get meter history
- `GET /meter-reading/readings/recent` - Get recent readings
- `GET /meter-reading/stats` - Get performance statistics

### **🔄 Sync Management (2 endpoints)**
- `GET /sync/pending` - Get pending sync status
- `POST /sync/force` - Force data synchronization

### **🛠️ Utilities (5 endpoints)**
- `GET /utils/areas` - Get available areas
- `GET /utils/routes` - Get available routes
- `GET /utils/system-info` - Get system information
- `GET /health` - Health check
- `GET /app-info` - App configuration

---

## 🔑 Authentication Flow

### 1. Mobile Login
**POST** `/api/v1/login`

Perfect for meter reader login with device tracking.

#### Request
```json
{
  "email": "admin@dunsinane.lk",
  "password": "password123",
  "device_name": "John's iPhone - iOS 17",
  "device_info": {
    "platform": "ios",
    "version": "17.0",
    "model": "iPhone 14 Pro",
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
    "token": "1|abcdef123456...",
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@dunsinane.lk",
      "role": "admin",
      "permissions": {
        "can_read_meters": true,
        "can_view_customer_details": true,
        "can_take_photos": true,
        "can_add_notes": true,
        "can_view_history": true,
        "can_edit_readings": true,
        "can_generate_reports": true
      }
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
      },
      "settings": {
        "max_photo_size": 5120,
        "auto_sync_interval": 300,
        "offline_storage_limit": 1000,
        "gps_accuracy_threshold": 10
      },
      "server_info": {
        "timezone": "Asia/Colombo",
        "currency": "LKR"
      }
    },
    "expires_at": "2024-02-10T15:30:00.000Z"
  }
}
```

### 2. Token Management
**GET** `/api/v1/check-token`
```http
Authorization: Bearer YOUR_TOKEN
```

**POST** `/api/v1/refresh` - Refresh expired token
**POST** `/api/v1/logout` - Revoke current token

---

## 📊 Core Mobile Features

### 1. Get Today's Route
**GET** `/api/v1/meter-reading/route/today`

Essential for daily meter reading operations.

#### Query Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| area | string | No | Filter by area (e.g., "Colombo") |
| route | string | No | Filter by route (e.g., "R001") |

#### Response
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
        "billing_status": "current"
      }
    ],
    "total_count": 25,
    "route_info": {
      "area": "Colombo",
      "route": "R001",
      "date": "2024-01-10",
      "reader": "Admin User"
    }
  }
}
```

### 2. Submit Meter Reading
**POST** `/api/v1/meter-reading/submit`

Core functionality for field operations.

#### Request (multipart/form-data)
```javascript
const formData = new FormData();
formData.append('customer_id', '1');
formData.append('meter_id', '1');
formData.append('current_reading', '1275.25');
formData.append('reading_date', '2024-01-10');
formData.append('gps_latitude', '6.9271');
formData.append('gps_longitude', '79.8612');
formData.append('notes', 'Meter in good condition');
formData.append('meter_condition', 'good');
formData.append('reading_accuracy', 'exact');

// Optional photo upload
if (photoUri) {
  formData.append('meter_photo', {
    uri: photoUri,
    type: 'image/jpeg',
    name: 'meter_photo.jpg'
  });
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
      "reader": "Admin User",
      "condition": "good",
      "accuracy": "exact",
      "notes": "Meter in good condition"
    },
    "receipt_data": {
      "receipt_number": "MR-000123",
      "date": "2024-01-10",
      "customer_info": "Alice Johnson - CN001",
      "consumption": "24.50 cubic meters",
      "reader": "Admin User"
    }
  }
}
```

### 3. Search Customers
**GET** `/api/v1/meter-reading/customers/search`

Essential for finding customers in the field.

#### Query Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| q | string | Yes | Search query (name, connection number, address) |
| limit | integer | No | Results limit (default: 20, max: 50) |

#### Example
```
GET /api/v1/meter-reading/customers/search?q=Alice&limit=10
```

#### Response
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
        "meter_number": "MT001",
        "current_reading": 1250.75,
        "status": "active"
      }
    ],
    "total_found": 1,
    "query": "Alice",
    "timestamp": "2024-01-10T10:30:00.000Z"
  }
}
```

### 4. Get Performance Statistics
**GET** `/api/v1/meter-reading/stats`

Dashboard data for mobile app.

#### Response
```json
{
  "success": true,
  "data": {
    "today": {
      "readings_completed": 15,
      "customers_visited": 15
    },
    "this_month": {
      "total_readings": 450,
      "total_consumption": 12500.75
    },
    "performance": {
      "average_readings_per_day": 15.0,
      "accuracy_rate": 98.5
    }
  }
}
```

### 5. Bulk Sync Offline Readings
**POST** `/api/v1/meter-reading/bulk-sync`

Critical for offline functionality.

#### Request
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
      "notes": "Offline reading",
      "meter_condition": "good",
      "reading_accuracy": "exact"
    }
  ]
}
```

---

## 🛠️ Utility Endpoints

### Get Areas & Routes
**GET** `/api/v1/utils/areas` - List all areas
**GET** `/api/v1/utils/routes?area=Colombo` - List routes in area

### System Information
**GET** `/api/v1/utils/system-info`
```json
{
  "success": true,
  "data": {
    "server_time": "2024-01-10T10:30:00.000Z",
    "timezone": "Asia/Colombo",
    "app_version": "1.0.0",
    "api_version": "v1",
    "maintenance_mode": false
  }
}
```

### Health Check
**GET** `/api/v1/health`
```json
{
  "status": "ok",
  "version": "1.0.0",
  "timestamp": "2024-01-10T10:30:00.000Z",
  "server": "Water Billing Management System API"
}
```

### App Configuration
**GET** `/api/v1/app-info`
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

---

## 📱 Mobile App Integration Guide

### React Native Example
```javascript
import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

// API Client Setup
const API_BASE_URL = 'https://erp.dunwassip.com/api/v1';

const apiClient = axios.create({
  baseURL: API_BASE_URL,
  timeout: 30000,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
});

// Token Management
apiClient.interceptors.request.use(async (config) => {
  const token = await AsyncStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Error Handling
apiClient.interceptors.response.use(
  (response) => response,
  async (error) => {
    if (error.response?.status === 401) {
      await AsyncStorage.multiRemove(['auth_token', 'user_data']);
      // Navigate to login
    }
    throw error;
  }
);

// Login Function
export const login = async (email, password, deviceName) => {
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
  
  await AsyncStorage.setItem('auth_token', response.data.data.token);
  return response.data;
};

// Get Today's Route
export const getTodaysRoute = async (area, route) => {
  const params = {};
  if (area) params.area = area;
  if (route) params.route = route;
  
  const response = await apiClient.get('/meter-reading/route/today', { params });
  return response.data;
};

// Submit Reading with Photo
export const submitReading = async (readingData, photoUri) => {
  const formData = new FormData();
  
  // Add reading data
  Object.keys(readingData).forEach(key => {
    if (readingData[key] !== null && readingData[key] !== undefined) {
      formData.append(key, readingData[key].toString());
    }
  });
  
  // Add photo if provided
  if (photoUri) {
    formData.append('meter_photo', {
      uri: photoUri,
      type: 'image/jpeg',
      name: 'meter_photo.jpg'
    });
  }
  
  const response = await apiClient.post('/meter-reading/submit', formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
    timeout: 60000, // Extended timeout for photo upload
  });
  
  return response.data;
};
```

### Flutter/Dart Example
```dart
import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  late Dio _dio;
  static const String baseUrl = 'https://erp.dunwassip.com/api/v1';
  
  ApiService() {
    _dio = Dio(BaseOptions(
      baseUrl: baseUrl,
      connectTimeout: Duration(seconds: 30),
      receiveTimeout: Duration(seconds: 30),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
    ));
    
    _dio.interceptors.add(InterceptorsWrapper(
      onRequest: (options, handler) async {
        final token = await _getToken();
        if (token != null) {
          options.headers['Authorization'] = 'Bearer $token';
        }
        handler.next(options);
      },
    ));
  }
  
  Future<String?> _getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('auth_token');
  }
  
  Future<Map<String, dynamic>> login(String email, String password, String deviceName) async {
    final response = await _dio.post('/login', data: {
      'email': email,
      'password': password,
      'device_name': deviceName,
      'device_info': {
        'platform': Platform.operatingSystem,
        'app_version': '1.0.0',
      }
    });
    
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', response.data['data']['token']);
    
    return response.data;
  }
  
  Future<Map<String, dynamic>> submitReading(Map<String, dynamic> data, [File? photo]) async {
    FormData formData = FormData.fromMap(data);
    
    if (photo != null) {
      formData.files.add(MapEntry(
        'meter_photo',
        await MultipartFile.fromFile(photo.path, filename: 'meter_photo.jpg'),
      ));
    }
    
    final response = await _dio.post('/meter-reading/submit', data: formData);
    return response.data;
  }
}
```

---

## 🔒 Security & Best Practices

### Authentication Headers
```http
Authorization: Bearer YOUR_ACCESS_TOKEN
Accept: application/json
Content-Type: application/json
```

### Rate Limiting
- **Limit:** 60 requests per minute per IP
- **Headers:** Check `X-RateLimit-Remaining`

### Photo Upload Guidelines
- **Max Size:** 5MB (5120 KB)
- **Formats:** JPEG, PNG, JPG
- **Recommended:** Compress images before upload
- **Field Name:** `meter_photo`

### GPS Accuracy
- **Latitude:** -90 to 90
- **Longitude:** -180 to 180
- **Recommended Accuracy:** ±10 meters

### Offline Support
- Store readings locally when offline
- Use `offline_timestamp` for sync
- Bulk sync with `/meter-reading/bulk-sync`

### Error Handling
```javascript
const handleApiError = (error) => {
  if (error.response) {
    switch (error.response.status) {
      case 401: return 'Authentication required';
      case 403: return 'Access forbidden';
      case 422: return 'Validation error';
      case 500: return 'Server error';
      default: return 'Request failed';
    }
  } else if (error.request) {
    return 'Network error - check connection';
  }
  return 'Unexpected error occurred';
};
```

---

## 🧪 Testing Checklist

### Pre-Launch Testing
- [ ] ✅ Authentication flow (login/logout/refresh)
- [ ] ✅ Today's route loading
- [ ] ✅ Customer search functionality
- [ ] ✅ Meter reading submission
- [ ] ✅ Photo upload with readings
- [ ] ✅ GPS coordinate capture
- [ ] ✅ Offline reading storage
- [ ] ✅ Bulk sync functionality
- [ ] ✅ Error handling for all endpoints
- [ ] ✅ Performance statistics display

### Production Endpoints (Ready)
```
✅ https://erp.dunwassip.com/api/v1/health
✅ https://erp.dunwassip.com/api/v1/app-info
✅ https://erp.dunwassip.com/api/v1/login
✅ All 22 endpoints documented and functional
```

---

## 📞 Support Information

**System:** Dunsinane Estate Water Supply and Management System  
**Developer:** Olexto Digital Solutions (Pvt) Ltd  
**Production URL:** https://erp.dunwassip.com  
**API Documentation:** /api/v1 (this document)

**Default Admin Credentials:**
- **Email:** admin@dunsinane.lk
- **Password:** password123

**Remember to change the default password in production!**

---

## 🎯 Mobile App Features Supported

✅ **User Authentication** with device tracking  
✅ **Daily Route Management** with GPS coordinates  
✅ **Real-time Meter Reading** submission  
✅ **Photo Capture** and upload  
✅ **Customer Search** and details  
✅ **Offline Reading** storage and sync  
✅ **Performance Dashboard** with statistics  
✅ **Receipt Generation** for customers  
✅ **Area/Route Filtering** for efficiency  
✅ **Comprehensive Error Handling**  

**Your API is production-ready for mobile app development!** 🚀 