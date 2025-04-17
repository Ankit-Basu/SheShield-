// Environment configuration for SheShield
// This file loads environment variables from the server

// Default empty configuration
window.ENV_CONFIG = {
  GEMINI_API_KEY: ''
};

// Function to load environment variables
async function loadEnvironmentConfig() {
  try {
    const response = await fetch('/api/env-config.php');
    if (response.ok) {
      const config = await response.json();
      window.ENV_CONFIG = { ...window.ENV_CONFIG, ...config };
      console.log('Environment configuration loaded');
    } else {
      console.error('Failed to load environment configuration');
    }
  } catch (error) {
    console.error('Error loading environment configuration:', error);
  }
}

// Load configuration when the script is executed
loadEnvironmentConfig();
