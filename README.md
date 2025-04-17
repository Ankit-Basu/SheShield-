# SheShield - Women's Safety & Support Platform

![SheShield Banner](screenshots/Screenshot%202025-04-17%20195503.png)

## 🛡️ Project Overview

SheShield is a comprehensive women's safety platform designed to provide 24/7 emergency support, incident reporting, and safety resources. The platform serves as a bridge between those who need help and those who can provide it, ensuring that no voice goes unheard and no incident goes unreported.

## ✨ Key Features

### Emergency SOS System
- One-click emergency alert system with location sharing
- Immediate notification to emergency contacts and nearby authorities
- Real-time tracking and status updates

![Emergency SOS](screenshots/Screenshot%202025-04-17%20195631.png)

### Incident Reporting
- Secure and anonymous reporting system
- Detailed incident documentation with media upload capabilities
- Case tracking and follow-up mechanisms

![Incident Reporting](screenshots/Screenshot%202025-04-17%20195638.png)

### Walk With Us
- Request trusted volunteers to accompany you
- Volunteer matching based on proximity and availability
- Real-time tracking and safety check-ins

![Walk With Us](screenshots/Screenshot%202025-04-17%20195649.png)

### AI-Powered Safety Assistant
- 24/7 chatbot providing safety information and guidance
- Contextual responses to safety queries
- Legal resources and emotional support

![AI Assistant](screenshots/Screenshot%202025-04-17%20195656.png)

### Safe Spaces Mapping
- Locate nearby safe spaces and women-friendly establishments
- Community-verified safety ratings
- Directions and contact information

![Safe Spaces](screenshots/Screenshot%202025-04-17%20195702.png)

### User Dashboard
- Personalized safety recommendations
- Incident history and status tracking
- Emergency contact management

![User Dashboard](screenshots/Screenshot%202025-04-17%20195727.png)

## 💻 Tech Stack

### Frontend
- HTML5, CSS3
- TailwindCSS for responsive design
- AlpineJS for interactive components
- JavaScript for dynamic content

### Backend
- PHP 7.4+
- MySQL database
- RESTful API architecture

### APIs and Services
- Geolocation API for location tracking
- PHPMailer for email notifications
- SMS gateway integration for alerts
- AI-powered chatbot integration

### Security
- HTTPS encryption
- Data anonymization
- Secure authentication
- Privacy-focused design

## 📱 Application Screenshots

### Homepage
![Homepage](screenshots/Screenshot%202025-04-17%20195503.png)

### About Us
![About Us](screenshots/Screenshot%202025-04-17%20195526.png)

### Safety Resources
![Safety Resources](screenshots/Screenshot%202025-04-17%20195746.png)

### Contact Page
![Contact Page](screenshots/Screenshot%202025-04-17%20195807.png)

### Settings
![Settings](screenshots/Screenshot%202025-04-17%20195819.png)

## 👥 Team

Our dedicated team of developers, designers, and safety advocates:

| Name | Role | Profile |
|------|------|---------|
| Ankit Basu | Project Lead & Backend Developer | ![Ankit](aboutus_images/ankit.jpeg) |
| Arsh | Frontend Developer | ![Arsh](aboutus_images/arsh.jpeg) |
| Sahil | UI/UX Designer | ![Sahil](aboutus_images/sahil.jpeg) |
| Vinay | Database Administrator | ![Vinay](aboutus_images/vinay.jpeg) |

## 🚀 Installation and Setup

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer for PHP dependencies
- Node.js and npm for frontend dependencies

### Installation Steps

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/sheshield.git
   cd sheshield
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install frontend dependencies
   ```bash
   npm install
   ```

4. Configure the database
   - Create a MySQL database
   - Import the SQL schema from `database_schema.sql`
   - Copy `config/email_config.example.php` to `config/email_config.php` and update with your settings

5. Configure email settings
   - See `EMAIL_SETUP.md` for detailed instructions

6. Start the development server
   ```bash
   php -S localhost:8000
   ```

7. Access the application at `http://localhost:8000`

## 📋 Project Structure

```
SheShield/
├── admin/               # Admin dashboard and management
├── api/                 # RESTful API endpoints
├── auth/                # Authentication system
├── config/              # Configuration files
├── css/                 # CSS stylesheets
├── database/            # Database connection and queries
├── emergency/           # Emergency response system
├── escort/              # Walk With Us feature
├── images/              # Static images
├── includes/            # Reusable PHP components
├── js/                  # JavaScript files
├── location/            # Location tracking functionality
├── models/              # Data models
├── PHPMailer/           # Email functionality
├── pro/                 # Frontend templates
├── safespace/           # Safe spaces mapping
├── screenshots/         # Application screenshots
├── sql/                 # SQL scripts
├── uploads/             # User-uploaded content
├── utils/               # Utility functions
└── vendor/              # Composer dependencies
```

## 🔒 Security Considerations

- All user data is encrypted and stored securely
- Location data is only shared during emergencies
- User information is anonymized in reports
- Regular security audits and updates
- GDPR and data protection compliance

## 🌟 Future Enhancements

- Mobile application development (iOS and Android)
- Integration with local law enforcement APIs
- Advanced AI for threat detection
- Community forums and support groups
- Multi-language support
- Offline functionality for emergency situations

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📞 Contact

For any inquiries, please reach out to us at [contact@sheshield.org](mailto:contact@sheshield.org)
