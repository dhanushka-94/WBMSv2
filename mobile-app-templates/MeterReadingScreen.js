import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  Alert,
  ScrollView,
  Image,
  StyleSheet,
  Dimensions,
  ActivityIndicator,
} from 'react-native';
import { launchCamera, launchImageLibrary } from 'react-native-image-picker';
import Geolocation from 'react-native-geolocation-service';
import { request, PERMISSIONS, RESULTS } from 'react-native-permissions';
import Icon from 'react-native-vector-icons/MaterialIcons';
import { useDispatch, useSelector } from 'react-redux';
import { submitReading } from '../store/slices/readingsSlice';
import NetInfo from '@react-native-netinfo/netinfo';
import DatabaseService from '../services/DatabaseService';

const { width } = Dimensions.get('window');

const MeterReadingScreen = ({ route, navigation }) => {
  const { customer } = route.params;
  const dispatch = useDispatch();
  const { isLoading } = useSelector(state => state.readings);
  
  // Form state
  const [currentReading, setCurrentReading] = useState('');
  const [notes, setNotes] = useState('');
  const [meterCondition, setMeterCondition] = useState('good');
  const [readingAccuracy, setReadingAccuracy] = useState('exact');
  const [photo, setPhoto] = useState(null);
  const [location, setLocation] = useState(null);
  const [isOnline, setIsOnline] = useState(true);
  
  // Validation state
  const [errors, setErrors] = useState({});
  const [consumption, setConsumption] = useState(0);

  useEffect(() => {
    // Check network status
    const unsubscribe = NetInfo.addEventListener(state => {
      setIsOnline(state.isConnected);
    });

    // Get current location
    requestLocationPermission();
    
    return () => unsubscribe();
  }, []);

  useEffect(() => {
    // Calculate consumption when reading changes
    if (currentReading && customer.meter.current_reading) {
      const consumption = Math.max(0, parseFloat(currentReading) - customer.meter.current_reading);
      setConsumption(consumption);
    }
  }, [currentReading, customer.meter.current_reading]);

  const requestLocationPermission = async () => {
    try {
      const result = await request(PERMISSIONS.ANDROID.ACCESS_FINE_LOCATION);
      if (result === RESULTS.GRANTED) {
        getCurrentLocation();
      }
    } catch (error) {
      console.warn('Location permission error:', error);
    }
  };

  const getCurrentLocation = () => {
    Geolocation.getCurrentPosition(
      (position) => {
        setLocation({
          latitude: position.coords.latitude,
          longitude: position.coords.longitude,
          accuracy: position.coords.accuracy,
        });
      },
      (error) => {
        console.warn('Location error:', error);
        Alert.alert(
          'Location Error',
          'Unable to get current location. Please ensure GPS is enabled.',
          [{ text: 'OK' }]
        );
      },
      {
        enableHighAccuracy: true,
        timeout: 15000,
        maximumAge: 10000,
      }
    );
  };

  const takePhoto = () => {
    Alert.alert(
      'Select Photo',
      'Choose how you want to add a meter photo',
      [
        { text: 'Camera', onPress: openCamera },
        { text: 'Gallery', onPress: openGallery },
        { text: 'Cancel', style: 'cancel' },
      ]
    );
  };

  const openCamera = () => {
    const options = {
      mediaType: 'photo',
      quality: 0.8,
      maxWidth: 1024,
      maxHeight: 1024,
      includeBase64: false,
      saveToPhotos: false,
    };

    launchCamera(options, (response) => {
      if (response.assets && response.assets[0]) {
        setPhoto(response.assets[0]);
      }
    });
  };

  const openGallery = () => {
    const options = {
      mediaType: 'photo',
      quality: 0.8,
      maxWidth: 1024,
      maxHeight: 1024,
      includeBase64: false,
    };

    launchImageLibrary(options, (response) => {
      if (response.assets && response.assets[0]) {
        setPhoto(response.assets[0]);
      }
    });
  };

  const validateForm = () => {
    const newErrors = {};

    // Reading validation
    if (!currentReading) {
      newErrors.reading = 'Current reading is required';
    } else if (isNaN(parseFloat(currentReading))) {
      newErrors.reading = 'Reading must be a valid number';
    } else if (parseFloat(currentReading) < 0) {
      newErrors.reading = 'Reading cannot be negative';
    } else if (
      customer.meter.type === 'cumulative' && 
      parseFloat(currentReading) < customer.meter.current_reading
    ) {
      newErrors.reading = 'Reading cannot be less than previous reading for cumulative meters';
    }

    // Consumption validation (warning, not error)
    if (consumption > 1000) {
      Alert.alert(
        'High Consumption Warning',
        `Consumption of ${consumption.toFixed(2)} m³ seems unusually high. Please verify the reading.`,
        [
          { text: 'Check Again', style: 'cancel' },
          { text: 'Continue', onPress: () => setErrors({}) },
        ]
      );
      return false;
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleSubmit = async () => {
    if (!validateForm()) {
      return;
    }

    try {
      const readingData = {
        customer_id: customer.id,
        meter_id: customer.meter.id,
        current_reading: parseFloat(currentReading),
        reading_date: new Date().toISOString().split('T')[0],
        gps_latitude: location?.latitude,
        gps_longitude: location?.longitude,
        notes: notes.trim(),
        meter_condition: meterCondition,
        reading_accuracy: readingAccuracy,
        meter_photo: photo,
        offline_timestamp: new Date().toISOString(),
      };

      if (isOnline) {
        // Submit online
        const result = await dispatch(submitReading(readingData));
        
        if (result.meta.requestStatus === 'fulfilled') {
          Alert.alert(
            'Success',
            'Meter reading submitted successfully!',
            [
              {
                text: 'Print Receipt',
                onPress: () => navigation.navigate('Receipt', { 
                  receiptData: result.payload.data.receipt_data 
                }),
              },
              {
                text: 'Continue',
                onPress: () => navigation.goBack(),
              },
            ]
          );
        } else {
          throw new Error(result.payload?.message || 'Submission failed');
        }
      } else {
        // Save offline
        const saved = await DatabaseService.saveOfflineReading(readingData);
        
        if (saved) {
          Alert.alert(
            'Saved Offline',
            'Reading saved locally. It will be synced when connection is restored.',
            [{ text: 'OK', onPress: () => navigation.goBack() }]
          );
        } else {
          throw new Error('Failed to save reading offline');
        }
      }
    } catch (error) {
      Alert.alert(
        'Error',
        error.message || 'Failed to submit meter reading. Please try again.',
        [{ text: 'OK' }]
      );
    }
  };

  return (
    <ScrollView style={styles.container} showsVerticalScrollIndicator={false}>
      {/* Header */}
      <View style={styles.header}>
        <Text style={styles.headerTitle}>Meter Reading</Text>
        <View style={styles.statusContainer}>
          <Icon 
            name={isOnline ? 'wifi' : 'wifi-off'} 
            size={16} 
            color={isOnline ? '#4CAF50' : '#f44336'} 
          />
          <Text style={[styles.statusText, { color: isOnline ? '#4CAF50' : '#f44336' }]}>
            {isOnline ? 'Online' : 'Offline'}
          </Text>
        </View>
      </View>

      {/* Customer Info Card */}
      <View style={styles.card}>
        <Text style={styles.cardTitle}>Customer Information</Text>
        <View style={styles.infoRow}>
          <Text style={styles.label}>Name:</Text>
          <Text style={styles.value}>{customer.name}</Text>
        </View>
        <View style={styles.infoRow}>
          <Text style={styles.label}>Connection:</Text>
          <Text style={styles.value}>{customer.connection_number}</Text>
        </View>
        <View style={styles.infoRow}>
          <Text style={styles.label}>Address:</Text>
          <Text style={styles.value}>{customer.address}</Text>
        </View>
        <View style={styles.infoRow}>
          <Text style={styles.label}>Meter No:</Text>
          <Text style={styles.value}>{customer.meter.meter_number}</Text>
        </View>
      </View>

      {/* Previous Reading Card */}
      <View style={styles.card}>
        <Text style={styles.cardTitle}>Previous Reading</Text>
        <View style={styles.readingContainer}>
          <View style={styles.readingBox}>
            <Text style={styles.readingLabel}>Last Reading</Text>
            <Text style={styles.readingValue}>{customer.meter.current_reading}</Text>
            <Text style={styles.readingUnit}>m³</Text>
          </View>
          <View style={styles.readingBox}>
            <Text style={styles.readingLabel}>Reading Date</Text>
            <Text style={styles.readingValue}>
              {customer.last_reading?.date || 'N/A'}
            </Text>
          </View>
        </View>
      </View>

      {/* Current Reading Input */}
      <View style={styles.card}>
        <Text style={styles.cardTitle}>Current Reading</Text>
        
        <View style={styles.inputContainer}>
          <Text style={styles.inputLabel}>Current Reading (m³) *</Text>
          <TextInput
            style={[styles.input, errors.reading && styles.inputError]}
            value={currentReading}
            onChangeText={setCurrentReading}
            placeholder="Enter current reading"
            keyboardType="numeric"
            returnKeyType="next"
          />
          {errors.reading && (
            <Text style={styles.errorText}>{errors.reading}</Text>
          )}
        </View>

        {/* Consumption Display */}
        {currentReading && (
          <View style={styles.consumptionContainer}>
            <Text style={styles.consumptionLabel}>Calculated Consumption:</Text>
            <Text style={styles.consumptionValue}>
              {consumption.toFixed(2)} m³
            </Text>
          </View>
        )}

        {/* Meter Condition */}
        <View style={styles.inputContainer}>
          <Text style={styles.inputLabel}>Meter Condition</Text>
          <View style={styles.buttonGroup}>
            {['good', 'damaged', 'needs_repair'].map((condition) => (
              <TouchableOpacity
                key={condition}
                style={[
                  styles.conditionButton,
                  meterCondition === condition && styles.conditionButtonActive,
                ]}
                onPress={() => setMeterCondition(condition)}
              >
                <Text
                  style={[
                    styles.conditionButtonText,
                    meterCondition === condition && styles.conditionButtonTextActive,
                  ]}
                >
                  {condition.replace('_', ' ').toUpperCase()}
                </Text>
              </TouchableOpacity>
            ))}
          </View>
        </View>

        {/* Reading Accuracy */}
        <View style={styles.inputContainer}>
          <Text style={styles.inputLabel}>Reading Accuracy</Text>
          <View style={styles.buttonGroup}>
            {['exact', 'estimated'].map((accuracy) => (
              <TouchableOpacity
                key={accuracy}
                style={[
                  styles.conditionButton,
                  readingAccuracy === accuracy && styles.conditionButtonActive,
                ]}
                onPress={() => setReadingAccuracy(accuracy)}
              >
                <Text
                  style={[
                    styles.conditionButtonText,
                    readingAccuracy === accuracy && styles.conditionButtonTextActive,
                  ]}
                >
                  {accuracy.toUpperCase()}
                </Text>
              </TouchableOpacity>
            ))}
          </View>
        </View>

        {/* Notes */}
        <View style={styles.inputContainer}>
          <Text style={styles.inputLabel}>Notes (Optional)</Text>
          <TextInput
            style={[styles.input, styles.textArea]}
            value={notes}
            onChangeText={setNotes}
            placeholder="Add any additional notes..."
            multiline
            numberOfLines={3}
            textAlignVertical="top"
          />
        </View>
      </View>

      {/* Photo Section */}
      <View style={styles.card}>
        <Text style={styles.cardTitle}>Meter Photo</Text>
        
        {photo ? (
          <View style={styles.photoContainer}>
            <Image source={{ uri: photo.uri }} style={styles.photoPreview} />
            <TouchableOpacity style={styles.changePhotoButton} onPress={takePhoto}>
              <Icon name="camera-alt" size={20} color="#2196F3" />
              <Text style={styles.changePhotoText}>Change Photo</Text>
            </TouchableOpacity>
          </View>
        ) : (
          <TouchableOpacity style={styles.photoButton} onPress={takePhoto}>
            <Icon name="camera-alt" size={32} color="#666" />
            <Text style={styles.photoButtonText}>Take Meter Photo</Text>
            <Text style={styles.photoButtonSubtext}>Recommended for verification</Text>
          </TouchableOpacity>
        )}
      </View>

      {/* Location Section */}
      <View style={styles.card}>
        <Text style={styles.cardTitle}>Location</Text>
        
        {location ? (
          <View style={styles.locationContainer}>
            <View style={styles.locationRow}>
              <Icon name="location-on" size={16} color="#4CAF50" />
              <Text style={styles.locationText}>Location captured</Text>
            </View>
            <Text style={styles.coordinatesText}>
              {location.latitude.toFixed(6)}, {location.longitude.toFixed(6)}
            </Text>
            <Text style={styles.accuracyText}>
              Accuracy: {location.accuracy?.toFixed(0)}m
            </Text>
          </View>
        ) : (
          <TouchableOpacity style={styles.locationButton} onPress={getCurrentLocation}>
            <Icon name="my-location" size={20} color="#2196F3" />
            <Text style={styles.locationButtonText}>Get Current Location</Text>
          </TouchableOpacity>
        )}
      </View>

      {/* Submit Button */}
      <View style={styles.submitContainer}>
        <TouchableOpacity
          style={[styles.submitButton, isLoading && styles.submitButtonDisabled]}
          onPress={handleSubmit}
          disabled={isLoading}
        >
          {isLoading ? (
            <ActivityIndicator color="#fff" />
          ) : (
            <>
              <Icon name="check" size={20} color="#fff" />
              <Text style={styles.submitButtonText}>
                {isOnline ? 'Submit Reading' : 'Save Offline'}
              </Text>
            </>
          )}
        </TouchableOpacity>
      </View>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: 16,
    backgroundColor: '#fff',
    borderBottomWidth: 1,
    borderBottomColor: '#e0e0e0',
  },
  headerTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    color: '#333',
  },
  statusContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
  },
  statusText: {
    fontSize: 12,
    fontWeight: '500',
  },
  card: {
    backgroundColor: '#fff',
    margin: 16,
    marginBottom: 0,
    borderRadius: 8,
    padding: 16,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },
  cardTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 12,
  },
  infoRow: {
    flexDirection: 'row',
    marginBottom: 8,
  },
  label: {
    fontSize: 14,
    color: '#666',
    width: 100,
    fontWeight: '500',
  },
  value: {
    fontSize: 14,
    color: '#333',
    flex: 1,
  },
  readingContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  readingBox: {
    alignItems: 'center',
    flex: 1,
  },
  readingLabel: {
    fontSize: 12,
    color: '#666',
    marginBottom: 4,
  },
  readingValue: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#2196F3',
  },
  readingUnit: {
    fontSize: 12,
    color: '#666',
  },
  inputContainer: {
    marginBottom: 16,
  },
  inputLabel: {
    fontSize: 14,
    fontWeight: '500',
    color: '#333',
    marginBottom: 8,
  },
  input: {
    borderWidth: 1,
    borderColor: '#ddd',
    borderRadius: 8,
    padding: 12,
    fontSize: 16,
    backgroundColor: '#fafafa',
  },
  inputError: {
    borderColor: '#f44336',
  },
  textArea: {
    height: 80,
  },
  errorText: {
    color: '#f44336',
    fontSize: 12,
    marginTop: 4,
  },
  consumptionContainer: {
    backgroundColor: '#e3f2fd',
    padding: 12,
    borderRadius: 8,
    marginTop: 8,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  consumptionLabel: {
    fontSize: 14,
    color: '#1976d2',
    fontWeight: '500',
  },
  consumptionValue: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#1976d2',
  },
  buttonGroup: {
    flexDirection: 'row',
    gap: 8,
  },
  conditionButton: {
    flex: 1,
    padding: 10,
    borderWidth: 1,
    borderColor: '#ddd',
    borderRadius: 6,
    alignItems: 'center',
  },
  conditionButtonActive: {
    backgroundColor: '#2196F3',
    borderColor: '#2196F3',
  },
  conditionButtonText: {
    fontSize: 12,
    color: '#666',
    fontWeight: '500',
  },
  conditionButtonTextActive: {
    color: '#fff',
  },
  photoContainer: {
    alignItems: 'center',
  },
  photoPreview: {
    width: width - 64,
    height: 200,
    borderRadius: 8,
    marginBottom: 12,
  },
  changePhotoButton: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
    padding: 8,
  },
  changePhotoText: {
    color: '#2196F3',
    fontSize: 14,
    fontWeight: '500',
  },
  photoButton: {
    alignItems: 'center',
    padding: 32,
    borderWidth: 2,
    borderColor: '#ddd',
    borderStyle: 'dashed',
    borderRadius: 8,
  },
  photoButtonText: {
    fontSize: 16,
    color: '#666',
    marginTop: 8,
    fontWeight: '500',
  },
  photoButtonSubtext: {
    fontSize: 12,
    color: '#999',
    marginTop: 4,
  },
  locationContainer: {
    padding: 12,
    backgroundColor: '#f8f9fa',
    borderRadius: 8,
  },
  locationRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
    marginBottom: 4,
  },
  locationText: {
    fontSize: 14,
    color: '#4CAF50',
    fontWeight: '500',
  },
  coordinatesText: {
    fontSize: 12,
    color: '#666',
    fontFamily: 'monospace',
  },
  accuracyText: {
    fontSize: 11,
    color: '#999',
    marginTop: 2,
  },
  locationButton: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    gap: 8,
    padding: 12,
    borderWidth: 1,
    borderColor: '#2196F3',
    borderRadius: 8,
  },
  locationButtonText: {
    color: '#2196F3',
    fontSize: 14,
    fontWeight: '500',
  },
  submitContainer: {
    padding: 16,
  },
  submitButton: {
    backgroundColor: '#4CAF50',
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    gap: 8,
    padding: 16,
    borderRadius: 8,
  },
  submitButtonDisabled: {
    backgroundColor: '#ccc',
  },
  submitButtonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
});

export default MeterReadingScreen; 