// Mock data for demonstration purposes
let chatData = [];

let welcomeMessageShown = false;

document.addEventListener('DOMContentLoaded', function () {
    // Add the welcome message only if it hasn't been shown yet
    if (!welcomeMessageShown) {
        chatData.push({ user: 'Owner', message: 'Welcome to the property chat!' });
        welcomeMessageShown = true;
    }

    // Display existing chat messages
    displayMessages();

    // Set up event listener for sending messages
    document.getElementById('messageInput').addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            sendMessage();
        }
    });
    const chatbox = document.getElementById('chatbox');
    chatbox.style.display = 'none';
});

function displayMessages() {
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.innerHTML = ''; // Clear existing messages to prevent duplicates

    chatData.forEach(item => {
        const messageElement = document.createElement('div');
        messageElement.textContent = `${item.user}: ${item.message}`;
        messageElement.classList.add(item.user === 'Owner' ? 'ownerMessage' : 'userMessage');
        chatMessages.appendChild(messageElement);
    });

    // Scroll to the bottom of the chatbox
    // chatMessages.scrollTop = chatMessages.scrollHeight;
}

function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const userMessage = messageInput.value.trim();

    if (userMessage !== '') {
        // Mock user (you can implement user authentication for real users)
        const user = 'Renter';

        // Add the user's question to the chat data
        chatData.push({ user, message: userMessage });

        // Check for predefined responses
        const response = getPredefinedResponse(userMessage);

        // If there's a predefined response, use it; otherwise, use a default response
        const replyMessage = response ? response : "I amm sorry, I didn't understand that. How can I assist you?";

        // Add the bot's response to the chat data
        chatData.push({ user: 'Owner', message: replyMessage });

        // Update the displayed messages
        displayMessages();

        // Clear the input field
        messageInput.value = '';
    }
}


function toggleChat() {
    const chatbox = document.getElementById('chatbox');
    chatbox.style.display = chatbox.style.display === 'none' ? 'block' : 'none';
}

// Function to get predefined responses based on user input
function getPredefinedResponse(userMessage) {
    // Map of predefined responses
    const predefinedResponses = {
        'hi': 'hello!',
        'how can I view available properties?': 'click on Property to explore our listings.',
        'interested to rent a property': 'great! We have a variety of properties available. How can I assist you further?',
        'how do I apply for a rental property?': 'applying for a rental property is easy! Once you find a property you are interested in, you can submit your application online through our website. Make sure to provide all required documents, and our team will review your application promptly. If you have any questions during the process, feel free to ask.',
    };

    // Check if the user's message has a predefined response
    const lowercaseMessage = userMessage.toLowerCase();
    return predefinedResponses[lowercaseMessage];
}
