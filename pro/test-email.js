require('dotenv').config();
const nodemailer = require('nodemailer');

const transporter = nodemailer.createTransport({
    service: 'gmail',
    host: 'smtp.gmail.com',
    port: 587,
    secure: false,
    auth: {
        user: process.env.EMAIL,
        pass: process.env.EMAIL_PASSWORD
    }
});

async function testEmail() {
    try {
        const info = await transporter.sendMail({
            from: process.env.EMAIL,
            to: process.env.RECIPIENT_EMAIL,
            subject: 'Test Email',
            text: 'This is a test email to verify the email service is working.'
        });
        console.log('Test email sent:', info.response);
    } catch (error) {
        console.error('Error sending test email:', error);
    }
}

testEmail();