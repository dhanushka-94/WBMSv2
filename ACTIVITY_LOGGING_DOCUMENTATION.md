# Activity Logging System Documentation

## Overview
The Water Billing Management System (WBMS) now includes a comprehensive activity logging system that tracks all user actions, providing detailed audit trails for security monitoring, compliance, and system administration.

## Features

### 🔍 **Comprehensive Activity Tracking**
- **User Actions**: Login, logout, CRUD operations, view actions
- **System Events**: Authentication events, session management
- **Data Changes**: Before/after values for all modifications
- **Request Context**: HTTP method, URL, route name, IP address, user agent
- **Performance Monitoring**: Request duration and status tracking
- **Error Logging**: Failed operations with error messages

### 📊 **Advanced Filtering & Search**
- Filter by user, action type, module, status, and date range
- Full-text search across descriptions and IP addresses
- Quick filters for common queries (today, this week, login events, CRUD operations)
- Real-time activity updates every 30 seconds

### 👤 **User-Specific Activity Views**
- Individual user activity timelines
- User statistics (today/week/total activities, last login)
- Quick navigation between users and their activities

### 📈 **Dashboard Analytics**
- Activity statistics with visual cards
- Module-wise activity breakdown
- Success/failure rate monitoring
- Performance metrics and trends

### 🔧 **Administration Features**
- Export activities to CSV/JSON formats
- Cleanup old activity logs
- Detailed view for each activity
- Quick action filters and bulk operations

## Technical Implementation

### Database Schema
**Table**: `activity_logs`

| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | User who performed the action |
| user_name | string | User's name (cached) |
| user_email | string | User's email (cached) |
| user_role | string | User's role (cached) |
| action | string | Action performed (login, create, update, etc.) |
| subject_type | string | Model class name (App\Models\Customer) |
| subject_id | bigint | ID of the affected model |
| subject_name | string | Display name of the affected model |
| description | text | Human-readable description |
| module | string | System module (customers, meters, billing, etc.) |
| method | string | HTTP method (GET, POST, PUT, DELETE) |
| url | string | Full request URL |
| route_name | string | Laravel route name |
| old_values | json | Previous values before change |
| new_values | json | New values after change |
| properties | json | Additional properties and metadata |
| ip_address | string | Client IP address |
| user_agent | text | Client user agent |
| session_id | string | Session identifier |
| status | string | Operation status (success, failed, error) |
| error_message | text | Error details if operation failed |
| duration_ms | integer | Request processing time in milliseconds |
| created_at | timestamp | When the activity occurred |
| updated_at | timestamp | Last update timestamp |

### Models & Relationships

#### ActivityLog Model
**Location**: `app/Models/ActivityLog.php`

**Key Features**:
- Eloquent relationships to User and polymorphic subject models
- Query scopes for filtering (byUser, byAction, byModule, today, thisWeek, etc.)
- Helper methods for logging (logActivity, logLogin, logLogout, logModelActivity)
- Accessors for formatted display (action_icon, status_badge, time_ago)
- Statistics methods for dashboard analytics

**Example Usage**:
```php
// Manual activity logging
ActivityLog::logActivity([
    'action' => 'custom_action',
    'description' => 'User performed a custom action',
    'module' => 'custom_module'
]);

// Model activity logging
ActivityLog::logModelActivity('updated', $customer, $oldData, $newData);

// Login/logout logging
ActivityLog::logLogin($user, true); // successful login
ActivityLog::logLogout($user);
```

### Middleware Integration

#### ActivityLogger Middleware
**Location**: `app/Http/Middleware/ActivityLogger.php`

**Functionality**:
- Automatically captures all authenticated user requests
- Intelligently determines action and module from routes
- Tracks request timing and performance
- Excludes non-essential requests (assets, debug routes)
- Captures request context and user information

**Configuration**: Registered in `bootstrap/app.php` web middleware group

### Trait Integration

#### LogsActivity Trait
**Location**: `app/Traits/LogsActivity.php`

**Purpose**: Provides easy-to-use methods for controllers to log specific activities

**Methods**:
- `logModelCreated($model, $description = null)`
- `logModelUpdated($model, $oldValues, $newValues, $description = null)`
- `logModelDeleted($model, $description = null)`
- `logBulkOperation($action, $count, $description = null)`
- `logVerification($model, $field, $description = null)`
- `logExport($type, $count, $description = null)`
- `logImport($type, $count, $description = null)`
- `logBillGeneration($count, $description = null)`
- `logPayment($bill, $amount, $description = null)`
- `logReportGeneration($type, $description = null)`
- `logConfigurationChange($setting, $oldValue, $newValue, $description = null)`

### Event Listeners

#### Authentication Events
**Location**: `app/Listeners/`

- **LoginListener**: Logs successful logins
- **LogoutListener**: Logs user logouts  
- **FailedLoginListener**: Logs failed login attempts

**Registration**: Configured in `app/Providers/AppServiceProvider.php`

### Controllers

#### ActivityLogController
**Location**: `app/Http/Controllers/ActivityLogController.php`

**Routes & Methods**:
- `GET /activity-logs` - Main dashboard with filtering
- `GET /activity-logs/{activity}` - Detailed activity view
- `GET /activity-logs/user/{user}` - User-specific activities
- `GET /activity-logs/export` - Export activities (CSV/JSON)
- `DELETE /activity-logs/cleanup` - Remove old activities
- `GET /activity-logs/stats` - Statistics API
- `GET /activity-logs/recent` - Recent activities API

### Views & UI

#### Main Dashboard
**Location**: `resources/views/activity-logs/index.blade.php`

**Features**:
- Statistics cards with key metrics
- Advanced filtering form with multiple criteria
- Real-time activity table with pagination
- Quick filter buttons for common queries
- Export and cleanup functionality
- Auto-refresh every 30 seconds

#### Detailed Activity View
**Location**: `resources/views/activity-logs/show.blade.php`

**Features**:
- Complete activity information display
- Before/after value comparison
- User and request context details
- Performance metrics and error information
- Quick action buttons for related queries

#### User Activity View
**Location**: `resources/views/activity-logs/user.blade.php`

**Features**:
- User-specific activity timeline
- User statistics and last login information
- Filtered views for user activities
- Activity type distribution charts

### Integration Points

#### Customer Controller Enhancement
**Location**: `app/Http/Controllers/CustomerController.php`

**Activities Logged**:
- Customer creation with full data capture
- Customer updates with before/after values
- Customer deletion with final state capture
- Customer view tracking

#### Navigation Integration
**Location**: `resources/views/layouts/navigation.blade.php`

- Added "Activity Logs" menu item to main navigation
- Responsive mobile menu integration
- Admin-level access control

## Usage Guide

### Accessing Activity Logs
1. Navigate to the main application
2. Click "Activity Logs" in the main menu
3. Use filters to find specific activities
4. Click on any activity for detailed information

### Filtering Activities
**Available Filters**:
- **User**: Filter by specific user
- **Action**: Filter by action type (login, create, update, delete, etc.)
- **Module**: Filter by system module (customers, meters, billing, etc.)
- **Status**: Filter by operation status (success, failed, error)
- **Date Range**: Filter by time period (today, yesterday, this week, this month)
- **Search**: Full-text search in descriptions and IP addresses

### Quick Filters
- **Today**: Show only today's activities
- **This Week**: Show activities from the current week
- **Login Events**: Show only authentication-related activities
- **CRUD Operations**: Show only create, read, update, delete operations

### Exporting Data
1. Apply desired filters
2. Click "Export" button
3. Choose format (CSV or JSON)
4. Download will start automatically

### User-Specific Views
1. From the main activity log, click on any user name
2. Or use the "Filter by User" quick action
3. View user's complete activity timeline
4. Access user statistics and patterns

## Security Considerations

### Data Protection
- Sensitive data (passwords, tokens) is automatically excluded from logging
- Personal information is cached to reduce database queries
- IP addresses and user agents are logged for security monitoring

### Access Control
- Activity logs are accessible only to authenticated users
- Admin-level permissions recommended for full access
- User-specific views may be restricted based on role

### Data Retention
- Automatic cleanup functionality for old logs
- Configurable retention periods
- Export capabilities for archival purposes

## Performance Optimization

### Database Indexing
- Indexed on user_id, action, module, status, and created_at
- Optimized queries for common filtering operations
- Pagination to handle large datasets

### Caching
- User information cached in activity logs to reduce joins
- Statistics cached for dashboard performance
- Real-time updates balanced with performance

### Background Processing
- Large exports handled asynchronously
- Cleanup operations can be scheduled
- Bulk operations optimized for performance

## Monitoring & Maintenance

### Health Checks
- Monitor activity log table size
- Track logging performance impact
- Review error rates and failed operations

### Regular Maintenance
- Schedule periodic cleanup of old logs
- Monitor disk space usage
- Review and update retention policies

### Troubleshooting
- Check middleware registration if logging stops
- Verify database connectivity for failed logs
- Review error logs for system issues

## Configuration

### Environment Variables
```env
# Activity logging settings (add to .env if needed)
ACTIVITY_LOG_RETENTION_DAYS=90
ACTIVITY_LOG_AUTO_CLEANUP=true
ACTIVITY_LOG_EXPORT_LIMIT=10000
```

### Customization Options
- Modify retention periods in cleanup methods
- Adjust auto-refresh intervals in views
- Customize action icons and status badges
- Add new activity types and modules

## Testing

The system has been thoroughly tested with:
- ✅ Database connectivity and table creation
- ✅ Activity log creation and retrieval
- ✅ Model relationships and accessors
- ✅ Query scopes and filtering
- ✅ Helper methods and static functions
- ✅ Customer activity integration
- ✅ Statistics and analytics

**Test Results**: All core functionality verified and working correctly.

## Future Enhancements

### Potential Improvements
- Real-time notifications for critical activities
- Advanced analytics and reporting
- Activity trend analysis and predictions
- Integration with external SIEM systems
- Mobile app activity tracking
- API activity logging
- Automated anomaly detection

### Scalability Considerations
- Database partitioning for large installations
- Redis caching for high-traffic sites
- Elasticsearch integration for advanced search
- Message queue integration for async logging

---

**System Status**: ✅ **FULLY OPERATIONAL**

The comprehensive activity logging system is now active and tracking all user activities in the Water Billing Management System. All features are implemented, tested, and ready for production use. 