import Chart from 'chart.js/auto'
import axios from 'axios';

async function fetchDataAndCreateChart() {
  try {
    const response = await axios.get("http://127.0.0.1:8000/api/graph");
    const newData = response.data.results;
    const newResponse = response.data.reviews;

    if (newData.length === 0 && newResponse.length === 0 ) {
      console.log('Non ci sono messaggi');
      return;
    }

    const dataMessage = newData.map(element => ({
      month: convertToMonth(element.month),
      count: element.message_count
    }));

    const dataReview = newResponse.map(element => ({
      month: convertToMonth(element.month),
      count: element.reviews_count
    }));

    createChart(dataMessage, dataReview);
  } catch (error) {
    console.error(error);
  }
}

// Chiamare la funzione principale
fetchDataAndCreateChart();

function createChart(dataMessage, dataReview) {
  (async function() {

    const allMonths = [
      'gennaio', 'febbraio', 'marzo', 'aprile', 'maggio', 'giugno',
      'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre'
    ];

    // Aggiungi i mesi mancanti al grafico
    const missingMonths = allMonths.filter(month => !dataMessage.some(entry => entry.month === month));
    missingMonths.forEach(month => {
      dataMessage.push({ month, count: 0 });
    });
    const missingMonthsRev = allMonths.filter(month => !dataReview.some(entry => entry.month === month));
    missingMonthsRev.forEach(month => {
      dataReview.push({ month, count: 0 });
    });

    // Ordina l'array in base all'ordine dei mesi
    dataMessage.sort((a, b) => allMonths.indexOf(a.month) - allMonths.indexOf(b.month));
    dataReview.sort((a, b) => allMonths.indexOf(a.month) - allMonths.indexOf(b.month));


    new Chart(
      document.getElementById('acquisitions'),
      {
        type: 'bar',
        data: {
          labels: dataMessage.map(row => row.month),
          labels: dataReview.map(row=> row.month),
          datasets: [
            {
              label: 'Numero di messaggi per mese',
              data: dataMessage.map(row => row.count),
              backgroundColor: 'rgba(75, 192, 192, 0.2)', // colore di sfondo per il primo dataset
              borderColor: 'rgba(75, 192, 192, 1)', // colore del bordo per il primo dataset
              borderWidth: 1, // larghezza del bordo per il primo dataset
            },
            {
              label: 'Numero recensioni per mese',
              data: dataReview.map(row => row.count),
              backgroundColor: 'rgba(255, 99, 132, 0.2)', // colore di sfondo per il secondo dataset
              borderColor: 'rgba(255, 99, 132, 1)', // colore del bordo per il secondo dataset
              borderWidth: 1, // larghezza del bordo per il secondo dataset
            }
          ]
        }
      }
    );
  })();
}
function convertToMonth(dateString) {
  const date = new Date(dateString);
  const options = { month: 'long' };
  return new Intl.DateTimeFormat('it-IT', options).format(date);
}


