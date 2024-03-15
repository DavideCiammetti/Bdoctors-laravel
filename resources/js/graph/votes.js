// JavaScript code goes here
import axios from "axios";
import Chart from "chart.js/auto";

// Fetch data from the API
async function fetchData() {
    try {
        const response = await axios.get(
            "http://127.0.0.1:8000/api/graph/votes"
        );
        const votes = response.data.votes;

        // Extract data for the chart
        const months = [];
        const voteIds = [];
        votes.forEach((vote) => {
            months.push(vote.month);
            voteIds.push(vote.vote_id);
        });

        // Draw the graph using Chart.js library
        const ctx = document.getElementById("voteIdChart").getContext("2d");
        const myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: months,
                datasets: [
                    {
                        label: "Voti",
                        data: voteIds,
                        borderColor: "rgba(75, 192, 192, 1)", // Turquoise color
                        borderWidth: 1,
                        fill: false,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                    },
                },
            },
        });
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}

fetchData();
