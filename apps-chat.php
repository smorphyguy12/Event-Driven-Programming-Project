<?php
include 'services/session.php';
include 'services/session-auth.php';
include 'partials/main.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title = "Chat";
    include 'partials/title-meta.php';
    include 'partials/head-css.php';
    ?>
</head>

<body>
    <div id="wrapper">
        <?php include 'partials/menu.php'; ?>

        <div class="content-page">
            <?php include 'partials/topbar.php'; ?>

            <div class="content">
                <div class="container-fluid">
                    <?php
                    $sub_title = "Apps";
                    $title = "Chat";
                    include 'partials/page-title.php';
                    ?>

                    <div class="row">
                        <!-- Chat Users -->
                        <div class="col-xl-3 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <!-- User Profile -->
                                    <div class="d-flex align-items-start mb-3">
                                        <img src="assets/images/users/user-1.jpg" class="me-2 rounded-circle" height="42" alt="<?= htmlspecialchars($username) ?>">
                                        <div class="w-100">
                                            <h5 class="mt-0 mb-0 font-15">
                                                <a href="contacts-profile.php" class="text-reset"><?= htmlspecialchars($username) ?></a>
                                            </h5>
                                            <p class="mt-1 mb-0 text-muted font-14">
                                                <small class="mdi mdi-circle text-success"></small> Online
                                            </p>
                                        </div>
                                        <a href="javascript:void(0);" class="text-reset font-20">
                                            <i class="mdi mdi-cog-outline"></i>
                                        </a>
                                    </div>

                                    <!-- Search Box -->
                                    <form class="search-bar mb-3">
                                        <div class="position-relative">
                                            <input type="text" id="user-search" class="form-control form-control-light" placeholder="Search users...">
                                            <span class="mdi mdi-magnify"></span>
                                        </div>
                                    </form>

                                    <!-- User List -->
                                    <div id="user-list">
                                        <div class="text-center">Loading users...</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Area -->
                        <div class="col-xl-9 col-lg-8" id="chat-area">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p>Select a user to start chatting</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'partials/footer.php'; ?>
        </div>
    </div>

    <?php
    include 'partials/right-sidebar.php';
    include 'partials/footer-scripts.php';
    ?>

    <script>
        $(document).ready(function() {
            const currentUserId = <?= json_encode($_SESSION['id']) ?>;
            let currentChatUserId = null;

            // Load users
            function loadUsers() {
                $.ajax({
                    url: 'get-users.php',
                    method: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        $('#user-list').html('<div class="text-center">Loading users...</div>');
                    },
                    success: function(users) {
                        const userList = $('#user-list');
                        userList.empty();
                        users.forEach(function(user) {
                            if (user.id !== currentUserId) {
                                userList.append(`
                                    <div class="user-list-item" data-user-id="${user.id}">
                                        <div class="d-flex align-items-start p-2">
                                            <img src="assets/images/users/user-${user.id}.jpg" class="me-2 rounded-circle" height="42" alt="${escapeHtml(user.username)}" />
                                            <div class="w-100">
                                                <h <h5 class="mt-0 mb-0 font-14">${escapeHtml(user.username)}</h5>
                                                <div id="user-status-${user.id}">
                                                    <!-- Status will be dynamically updated -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            }
                        });
                    },
                    error: function() {
                        $('#user-list').html('<div class="text-danger">Failed to load users. Please try again later.</div>');
                    }
                });
            }

            // Load messages for a specific user
            function loadMessages(userId) {
                currentChatUserId = userId;
                $.ajax({
                    url: 'get-messages.php',
                    method: 'GET',
                    data: {
                        id: userId
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#chat-area').html('<div class="text-center">Loading messages...</div>');
                    },
                    success: function(response) {
                        if (response.messages && response.recipient) {
                            renderChatArea(response.recipient, response.messages);
                        } else {
                            console.error('Invalid response format:', response);
                            alert('Error: Invalid response from server');
                        }
                    },
                    error: function(xhr) {
                        try {
                            const errorResponse = JSON.parse(xhr.responseText);
                            console.error('Server Error:', errorResponse);
                            alert(`Error: ${errorResponse.details || 'Unknown error'}`);
                        } catch (e) {
                            console.error('Parsing error:', e);
                            alert('Unexpected error loading messages');
                        }
                    }
                });
            }

   

            // Render chat area with messages
            function renderChatArea(user, messages) {
                const chatArea = $('#chat-area');
                chatArea.html(`
                    <div class="card">
                        <div class="card-body py-2 px-3 border-bottom border-light">
                            <div class="row justify-content-between py-1">
                                <div class="col-sm-7">
                                    <div class="d-flex align-items-start">
                                        <img src="assets/images/users/user-${user.id}.jpg" class="me-2 rounded-circle" height="36">
                                        <div>
                                            <h5 class="mt-0 mb-0 font-15" id="chat-user-name">
                                                ${escapeHtml(user.username)}
                                            </h5>
                                            <div id="user-status-${user.id}">
                                                <!-- Status will be dynamically updated -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="conversation-list" id="message-list" data-simplebar style="max-height: 460px;">
                                ${renderMessageList(messages)}
                            </ul>
                            <div class="row">
                                <div class="col">
                                    <div class="mt-2 bg-light p-3 rounded">
                                        <form id="chat-form">
                                            <div class="row">
                                                <div class="col mb-2 mb-sm-0">
                                                    <input type="text" id="message-input" class="form-control border-0" placeholder="Enter your message" required />
                                                </div>
                                                <div class="col-sm-auto">
                                                    <button type="submit" class="btn btn-success chat-send w-100">
                                                        <i class="fe-send"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            }

            // Helper function to escape HTML to prevent XSS
            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Render message list with sender's username
            function renderMessageList(messages) {
                return messages.map(msg => `
                    <li class="clearfix ${msg.sender_id == currentUserId ? 'odd' : ''}">
                        <div class="conversation-text">
                            <div class="ctext-wrap">
                                <strong>${escapeHtml(msg.sender_username)}</strong>
                                <p>${escapeHtml(msg.message)}</p>
                                <small class="text-muted">${new Date(msg.timestamp).toLocaleTimeString()}</small>
                            </div>
                        </div>
                    </li>
                `).join('');
            }

            // Send message
            $(document).on('submit', '#chat-form', function(e) {
                e.preventDefault();
                const message = $('#message-input').val().trim();

                if (message === '') {
                    alert('Please enter a message.');
                    return;
                }

                $.ajax({
                    url: 'send-message.php',
                    method: 'POST',
                    data: {
                        receiver_id: currentChatUserId,
                        message: message
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message-input').val('');
                            loadMessages(currentChatUserId);
                        } else {
                            alert('Error sending message: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while sending the message.');
                    }
                });
            });

            // Click event for user selection
            $(document).on('click', '.user-list-item', function() {
                const userId = $(this).data('user-id');
                loadMessages(userId);
            });

            // Initial load of users
            loadUsers();

            // Global variables
            let userStatusInterval;
            const ACTIVITY_TIMEOUT = 5 * 60 * 1000; // 5 minutes

            // Update user status
            function updateUserStatus(status = 'online') {
                $.ajax({
                    url: 'update-status.php',
                    method: 'POST',
                    data: {
                        status: status
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Status updated:', response);
                    },
                    error: function(xhr) {
                        console.error('Status update failed', xhr.responseText);
                    }
                });
            }

            // Check specific user's status
            function checkUserStatus(userId) {
                $.ajax({
                    url: 'get-user-status.php',
                    method: 'GET',
                    data: {
                        user_id: userId
                    },
                    dataType: 'json',
                    success: function(userStatus) {
                        updateUserStatusDisplay(userStatus);
                    },
                    error: function(xhr) {
                        console.error('Failed to get user status', xhr.responseText);
                    }
                });
            }

            // Update UI to reflect user status
            function updateUserStatusDisplay(userStatus) {
                const statusElement = $('#user-status-' + userStatus.id);

                if (userStatus.activity_status === 'online') {
                    statusElement.html(`
                        <span class="badge bg-success">Online</span>
                    `);
                } else {
                    statusElement.html(`
                        <span class="badge bg-secondary">Offline</span>
                    `);
                }
            }

            // Track user activity
            function setupActivityTracking() {
                // Update status to online when user is active
                const events = ['mousemove', 'keypress', 'scroll', 'click'];
                events.forEach(event => {
                    document.addEventListener(event, () => {
                        updateUserStatus('online');
                    });
                });

                // Periodic status update
                userStatusInterval = setInterval(() => {
                    updateUserStatus('online');
                }, 3 * 60 * 1000); // Every 3 minutes

                // Set status to away when user is inactive
                let inactivityTimer = setTimeout(() => {
                    updateUserStatus('away');
                }, ACTIVITY_TIMEOUT);

                // Reset inactivity timer on activity
                events.forEach(event => {
                    document.addEventListener(event, () => {
                        clearTimeout(inactivityTimer);
                        inactivityTimer = setTimeout(() => {
                            updateUserStatus('away');
                        }, ACTIVITY_TIMEOUT);
                    });
                });

                // Set status to offline on page unload
                window.addEventListener('beforeunload', () => {
                    updateUserStatus('offline');
                    clearInterval(userStatusInterval);
                });
            }

            // Initialize on document ready
            setupActivityTracking();

            // Example: Check status of a specific user
            if (currentChatUserId) {
                checkUserStatus(currentChatUserId);
            }
        });
    </script>
</body>

</html>