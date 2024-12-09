const announcements = [
    {
        id: 1,
        title: "End of School Year Ceremony",
        content: "Join us for the annual End of School Year Ceremony on June 15th, 2024 at 10:00 AM in the school auditorium.",
        date: "2024-03-15",
        priority: "high",
        category: "events",
        read: false
    },
    {
        id: 2,
        title: "Last Day of Enrollment",
        content: "Final day of enrollment for the academic year 2023-2024 will commence on May 1st, 2024. Please check the detailed schedule attached.",
        date: "2024-03-14",
        priority: "high",
        category: "enrollment",
        read: false
    },
    {
        id: 3,
        title: "School Maintenance Notice",
        content: "The school gymnasium will be closed for maintenance from March 20-25, 2024.",
        date: "2024-03-13",
        priority: "medium",
        category: "administrative",
        read: true
    }
];

// Function to create announcement cards
function createAnnouncementCard(announcement) {
    const card = document.createElement('div');
    card.className = 'announcement-card';
    card.innerHTML = `
        <div class="announcement-header">
            <h2 class="announcement-title">${announcement.title}</h2>
            <div class="announcement-meta">
                <span class="announcement-date">${formatDate(announcement.date)}</span>
                <span class="announcement-priority priority-${announcement.priority}">${announcement.priority.toUpperCase()}</span>
            </div>
        </div>
        <div class="announcement-content">
            ${announcement.content}
        </div>
        <div class="announcement-footer">
            <span class="announcement-category">${announcement.category}</span>
    
        </div>
    `;
    return card;
}

// Function to format date
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString(undefined, options);
}

// Function to filter announcements
function filterAnnouncements(category) {
    const container = document.querySelector('.announcements-container');
    container.innerHTML = '';
    
    const filteredAnnouncements = category === 'all' 
        ? announcements 
        : announcements.filter(a => a.category === category);

    filteredAnnouncements.forEach(announcement => {
        container.appendChild(createAnnouncementCard(announcement));
    });
}

// Initialize the page
let currentFilter = 'all';
document.addEventListener('DOMContentLoaded', () => {
    // Initial load of announcements
    filterAnnouncements('all');

    // Set up filter buttons
    const filterButtons = document.querySelectorAll('.filter-button');
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            currentFilter = button.dataset.filter;
            filterAnnouncements(currentFilter);
        });
    });
});