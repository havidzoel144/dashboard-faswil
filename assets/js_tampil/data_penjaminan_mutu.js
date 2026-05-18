$(document).ready(function () {
  // Membuat array untuk data dan labels
  // Filter data: ambil semua tipologi kecuali null/kosong
  data_tipologi = (data_tipologi || []).filter((item) => {
    const t = item?.tipologi;
    return (
      t !== null &&
      t !== undefined &&
      String(t).trim() !== "" &&
      String(t).toLowerCase() !== "null"
    );
  });
  const isDataKosong = data_tipologi.length === 0;
  const labels = isDataKosong
    ? ["Data Kosong"]
    : data_tipologi.map((item) => item.tipologi); // Ambil semua nama tipologi
  const jumlah = isDataKosong
    ? [0]
    : data_tipologi.map((item) => parseInt(item.jumlah_tipologi)); // Ambil jumlah_tipologi sebagai angka
  const $total_data = isDataKosong
    ? [0]
    : data_tipologi.map((item) => parseInt(item.total_data)); // Ambil total_data sebagai angka
  const $periode = isDataKosong
    ? [""]
    : data_tipologi.map((item) => item.periode); // Ambil periode
  const $prd = !isDataKosong
    ? $periode[0].slice(-1) == 1
      ? $periode[0].substring(0, 4) + " Periode 1"
      : $periode[0].substring(0, 4) + " Periode 2"
    : "";

  // Tambahkan array persentase dengan menghitung persentase dari jumlah_tipologi
  const percentages = isDataKosong
    ? [100]
    : data_tipologi.map((item) => {
        const total = parseInt(item.total_data) || 0;
        const jml = parseInt(item.jumlah_tipologi) || 0;
        const percentage = total > 0 ? (jml / total) * 100 : 0;
        return percentage.toFixed(1); // Membatasi 1 digit setelah koma
      });

  // Mendapatkan elemen canvas
  const canvas = document.getElementById("doughnutChart");

  // Membuat objek data dengan konfigurasi chart
  const data = {
    // labels: ['Tipologi 1', 'Tipologi 2', 'Tipologi 3', 'Tipologi 4'],
    labels: labels,
    datasets: [
      {
        // data: [data_tipologi.tipologi_1, data_tipologi.tipologi_2, data_tipologi.tipologi_3, data_tipologi.tipologi_4],
        data: percentages,
        jumlah: jumlah,
        backgroundColor: isDataKosong
          ? ["#D3D3D3"]
          : ["#0796B7", "#0000CD", "#FFA360", "#00008B"],
        // backgroundColor: ['rgba(0, 128, 0, 0.2)', 'rgba(255, 255, 0, 0.2)', 'rgba(255, 165, 0, 0.2)', 'rgba(255, 0, 0, 0.2)'],
        hoverBackgroundColor: isDataKosong
          ? ["#C0C0C0"]
          : ["#046980", "#00008F", "#B27243", "#000061"],
        // hoverBackgroundColor: ['rgba(0, 128, 0, 0.2)', 'rgba(255, 255, 0, 0.2)', 'rgba(255, 165, 0, 0.2)', 'rgba(255, 0, 0, 0.2)']
        borderWidth: 4,
        borderColor: "white",
        hoverBorderColor: "black",
      },
    ],
  };

  // Opsi tambahan untuk kustomisasi chart
  const options = {
    responsive: true, // Membuat chart responsif sesuai ukuran kontainer
    plugins: {
      legend: {
        display: true, // Menampilkan legenda
        position: "top", // Posisi legenda (top, bottom, left, right)
        labels: {
          generateLabels: (chart) => {
            const datasets = chart.data.datasets;
            return datasets[0].data.map((data, i) => ({
              text: isDataKosong
                ? `${chart.data.labels[i]}`
                : `${chart.data.labels[i]}: ${datasets[0].jumlah[i]} PT`,
              fillStyle: datasets[0].backgroundColor[i],
              strokeStyle: datasets[0].backgroundColor[i],
              index: i,
            }));
          },
        },
      },
      tooltip: {
        enabled: true, // Mengaktifkan tooltip saat hover
        callbacks: {
          label: function (tooltipItem) {
            if (isDataKosong) return "Data Kosong";
            const index = tooltipItem.dataIndex;
            const value = tooltipItem.dataset["jumlah"][index];
            const label = tooltipItem.label; // Ambil label (Tipologi 1, 2, dst.)
            const percentage = tooltipItem.raw; // Ambil persentase
            return `${label}: ${value} (${percentage}%)`;
          },
        },
      },
      title: {
        display: true, // Menampilkan judul
        text: isDataKosong
          ? "Distribusi Tipologi - Data Kosong"
          : "Distribusi Tipologi " + $prd, // Teks judul
        font: {
          size: 18, // Ukuran font judul
        },
      },
      datalabels: {
        color: "#000", // Warna label
        backgroundColor: "white",
        anchor: "center", // Posisi label
        align: "center", // Penyelarasan label
        formatter: (value, context) => {
          if (isDataKosong) return "Data Kosong";
          const label = context.chart.data.labels[context.dataIndex];
          const jumlah =
            context.chart.data.datasets[0].jumlah[context.dataIndex];
          // return `${label}: ${jumlah} (${value}%)`; // Format teks label
          return `${jumlah} (${value}%)`; // Format teks label
        },
      },
      annotation: {
        annotations: {
          dLabel: {
            type: "doughnutLabel",
            content: ({ chart }) =>
              isDataKosong ? ["Data Kosong"] : ["Total", $total_data[0]],
            font: isDataKosong
              ? [
                  {
                    size: 28,
                  },
                ]
              : [
                  {
                    size: 40,
                  },
                  {
                    size: 30,
                  },
                ],
            color: isDataKosong ? ["#666"] : ["black", "red"],
          },
        },
      },
    },
    animation: {
      animateScale: true, // Mengaktifkan animasi skala
      animateRotate: true, // Mengaktifkan animasi rotasi
    },
    cutout: "50%", // Ukuran lubang di tengah chart
  };

  // Membuat chart doughnut
  new Chart(canvas, {
    type: "doughnut",
    data: data,
    options: options, // Menambahkan opsi di sini
    plugins: [ChartDataLabels], // Tambahkan plugin datalabels di sini
  });
});
