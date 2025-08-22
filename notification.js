
function fetchNotifications() {
    fetch('/get-notifications.php') // Replace with the correct path
        .then(response => response.json())
        .then(data => {
            const notificationList = document.getElementById('notification-list');
            notificationList.innerHTML = '';

            if (data.length > 0) {
                data.forEach(notification => {
                    const notificationItem = `
                        <div class="drop_1i1 clearfix">
                            <div class="col-sm-12">
                                <div class="drop_1i1l clearfix">
                                    <h6 class="mgt bold">${notification.message}</h6>
                                    <span class="normal col_2">${new Date(notification.time).toLocaleString()}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    notificationList.insertAdjacentHTML('beforeend', notificationItem);
                });
            } else {
                notificationList.innerHTML = '<p class="text-center">No notifications</p>';
            }
        })
        .catch(error => console.error('Error fetching notifications:', error));
}

// Call fetchNotifications after the DOM is ready
document.addEventListener("DOMContentLoaded", fetchNotifications);