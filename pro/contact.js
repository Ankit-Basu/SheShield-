document.getElementById('contactForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const formProps = Object.fromEntries(formData);

    try {
        const response = await fetch('http://localhost:3000/api/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formProps)
        });

        const data = await response.json();

        if (response.ok) {
            alert('Message sent successfully!');
            e.target.reset();
        } else {
            throw new Error(data.message || 'Error sending message');
        }
    } catch (error) {
        alert('Error sending message. Please try again later.');
        console.error('Error:', error);
    }
});