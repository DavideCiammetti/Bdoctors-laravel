// JavaScript code goes here
import axios from "axios";

// Fetch data from the API
async function fetchData() {
    try {
        const response = await axios.get("http://127.0.0.1:8000/api/graph");
        const doctorMessages = response.data.results;
        const doctorReviews = response.data.reviews;

        // Function to count occurrences of messages and reviews per month
        function countOccurrencesByMonth(data) {
            const counts = {};
            data.forEach((item) => {
                const month = item.month; // Assuming month is in the format 'YYYY-MM'
                if (!counts[month]) counts[month] = { messages: 0, reviews: 0 };
                counts[month].messages += item.message_count;
            });
            return counts;
        }

        // Merge counts from messages and reviews
        const counts = Object.assign(
            {},
            countOccurrencesByMonth(doctorMessages)
        );
        doctorReviews.forEach((item) => {
            const month = item.month;
            if (!counts[month]) counts[month] = { messages: 0, reviews: 0 };
            counts[month].reviews += item.reviews_count;
        });

        // Draw the graph using Chart.js library
        const today = new Date();
        const currentMonth = `${today.getFullYear()}-${(today.getMonth() + 1)
            .toString()
            .padStart(2, "0")}`;
        const months = [];
        for (let i = 11; i >= 0; i--) {
            const date = new Date(today.getFullYear(), today.getMonth() - i, 1);
            months.push(
                `${date.getFullYear()}-${(date.getMonth() + 1)
                    .toString()
                    .padStart(2, "0")}`
            );
        }

        const messageData = [];
        const reviewData = [];
        months.forEach((month) => {
            messageData.push(counts[month]?.messages || 0);
            reviewData.push(counts[month]?.reviews || 0);
        });

        const ctx = document.getElementById("myChart").getContext("2d");
        const myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: months,
                datasets: [
                    {
                        label: "Messaggi",
                        data: messageData,
                        backgroundColor: "rgba(255, 99, 132, 0.5)", // Red
                    },
                    {
                        label: "Recensioni",
                        data: reviewData,
                        backgroundColor: "rgba(54, 162, 235, 0.5)", // Blue
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10, // Maximum value for y-axis
                    },
                },
            },
        });
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

fetchData();
