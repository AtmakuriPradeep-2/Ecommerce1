document.addEventListener("DOMContentLoaded", function () {
    const chatIcon = document.getElementById("chat-icon");
    const chatbot = document.getElementById("chatbot");
    const closeChat = document.getElementById("close-chat");

    // Show Chatbot on Click
    chatIcon.addEventListener("click", function () {
        chatbot.style.display = "block";
        chatIcon.style.display = "none"; // Hide icon when chat is open
    });

    // Close Chatbot on Click
    closeChat.addEventListener("click", function () {
        chatbot.style.display = "none";
        chatIcon.style.display = "flex"; // Show icon again when chat is closed
    });
});
