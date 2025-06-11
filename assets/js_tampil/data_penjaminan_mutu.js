$(document).ready(function () {
  var dataTable = $('#tabel-penjaminan-mutu').DataTable({
    dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
    processing: true,
    serverSide: true,
    searching: true,
    language: {
      search: "",
      searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
    },
    ajax: {
      url: baseURL + "beranda/Penjaminan_mutu/data_penjaminan_mutu",
      type: "POST",
      data: function (d) {
        // Mendapatkan tahun saat ini
        var currentYear = new Date().getFullYear();
        // Mendapatkan bulan saat ini (0-11, Januari = 0)
        var currentMonth = new Date().getMonth() + 1; // Ditambah 1 agar Januari = 1, Desember = 12

        // Menentukan periode: 1 untuk Januari-Juni, 2 untuk Juli-November
        var periodSuffix = (currentMonth >= 1 && currentMonth <= 6) ? '1' : '2';
        d.periode = currentYear + periodSuffix;
        d[csrfName] = csrfHash; // ← Tambahkan ini
      },
      dataSrc: function (json) {
        csrfHash = json.csrfHash; // ← Token diperbarui setelah response
        return json.data; // ← Return data yang akan ditampilkan di tabel
      }
    },
    columnDefs: [{
      orderable: false,
      targets: [0, 1, 4, 5, 6]
    }],
    order: [
      [2, "asc"]
    ]
  });

  // RIWAYAT SPMI
  var dataTable_riwayat = $('#tabel-riwayat-penjaminan-mutu').DataTable({
    dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
    processing: true,
    serverSide: true,
    searching: true,
    language: {
      search: "",
      searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
    },
    ajax: {
      url: baseURL + "beranda/Penjaminan_mutu/data_penjaminan_mutu",
      type: "POST",
      data: function (d) {
        d[csrfName] = csrfHash; // ← Tambahkan ini
      },
      dataSrc: function (json) {
        csrfHash = json.csrfHash; // ← Token diperbarui setelah response
        return json.data; // ← Return data yang akan ditampilkan di tabel
      }
    },
    order: [
      [2, "asc"]
    ]
  });

  // Pindahkan kotak pencarian DataTables
  $("#tabel-penjaminan-mutu_filter").detach().appendTo('#search-container');
  $("#tabel-riwayat-penjaminan-mutu_filter").detach().appendTo('#search-container');

  $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
  $('.dataTables_filter input[type="search"]').addClass('border-bottom');
  $('.dataTables_filter label').css({
    'width': '100%'
  });

  $('#kode_pt').select2().on("change", function (e) { //Search by Kode PT
    var selectedKodePT = $(this).val().trim(); // Mendapatkan nilai yang dipilih pada elemen select
    dataTable.column(1).search(selectedKodePT).draw();
  });

  let fullData = []; // Simpan data lengkap di variabel global
  $('#kode_pt_riwayat').select2().on("change", function (e) { //Search by Kode PT
    var selectedKodePTRiwayat = $(this).val().trim(); // Mendapatkan nilai yang dipilih pada elemen select
    // Mengirim data dengan AJAX
    $.ajax({
      url: baseURL + 'get-data-pt', // Endpoint untuk mendapatkan data
      type: 'POST',
      data: {
        kode_pt: selectedKodePTRiwayat,
        [csrfName]: csrfHash // ✅ Benar
      },
      dataType: 'json',
      success: function (response) {
        // ✅ Perbarui CSRF token dulu
        if (response.csrfHash) {
          csrfHash = response.csrfHash;
        }

        // Pastikan respons berisi `labels` dan `values`
        if (response.success) {
          fullData = response.data;
          xMin = 0; // Reset range awal
          xMax = 3; // Tampilkan 4 data pertama
          updateChart(fullData); // Perbarui chart pertama kali
          // updateChart(response.data); // Perbarui chart dengan data baru
          $('#lineChart').removeClass('d-none')
          // $('#chartLegends').removeClass('d-none')
          $('#chartMessage').addClass('d-none')
        } else {
          $('#lineChart').addClass('d-none')
          // $('#chartLegends').addClass('d-none')
          $('#chartMessage').removeClass('d-none')
          if (lineChart) {
            lineChart.destroy(); // Hancurkan chart sebelumnya
          }
          // alert('Gagal mendapatkan data.');
          // alert(response.message || 'Terjadi kesalahan.');
          Swal.fire({
            title: "Warning!",
            text: response.message || 'Terjadi kesalahan.',
            icon: "warning"
          });
        }
      },
      error: function () {
        // alert('Terjadi kesalahan saat mengambil data.');
        alert('Gagal memproses permintaan.');
      }
    });
  });

  // Sembunyikan alert flash message setelah 3 detik (3000 ms)
  setTimeout(function () {
    $('#flash-message').fadeOut('slow');
  }, 2000); // 3 detik


  // Inisialisasi Chart.js
  const ctx = document.getElementById('lineChart').getContext('2d');
  let lineChart;
  // Variabel untuk mengatur range pan
  const panStep = 1; // Jumlah data yang digeser per langkah pan
  let xMin = 0; // Indeks awal data yang terlihat
  let xMax = 3; // Indeks akhir data yang terlihat (4 titik)

  // Fungsi untuk memperbarui chart
  function updateChart(data) {
    // Gunakan map untuk mengolah data
    const labels = data.map(item => formatPeriode(item.periode)); // Format periode dengan map
    const values = data.map(item => parseFloat(item.skor_total)); // Ambil skor total
    const nama_pt = data.map(item => item.nama_pt); // Ambil PT
    const tipologi = data.map(item => item.tipologi); // Ambil Tipologi

    if (lineChart) {
      lineChart.destroy(); // Hancurkan chart sebelumnya
    }

    // Membuat chart baru dengan data terbaru
    lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Skor Total',
          data: values, // Data nilai dari hasil AJAX
          tipologi: tipologi, // Tambahkan tipologi di sini
          borderColor: 'rgba(64, 5, 137, 0.91)',
          backgroundColor: 'rgba(114, 0, 255, 0.91)',
          borderWidth: 2,
          fill: false,
          pointStyle: 'circle',
          pointRadius: 5,
          pointHoverRadius: 10
        }]
      },
      options: {
        animations: {
          radius: {
            duration: 400,
            easing: 'linear',
            loop: (context) => context.active
          }
        },
        hoverRadius: 12,
        hoverBackgroundColor: 'rgba(255, 114, 0, 1)',
        interaction: {
          intersect: false,
          mode: 'index',
        },
        responsive: true,
        plugins: {
          tooltip: {
            callbacks: {
              label: function (context) {
                let label = context.dataset.label || '';
                let value = context.raw || '';
                let index = context.dataIndex; // Dapatkan indeks data
                let currentTipologi = context.chart.data.datasets[0].tipologi[index]; // Ambil tipologi dari data

                // Format label tooltip
                return `${label}: ${value} (${currentTipologi})`;
              }
            }
          },
          legend: {
            display: false,
            position: 'top',
          },
          title: {
            display: true,
            text: 'Grafik Skor Total: ' + nama_pt[0],
            font: {
              family: 'Open Sans',
              size: 20,
              weight: 'bold',
              lineHeight: 1.2
            },
          },
          zoom: {
            pan: {
              enabled: true, // Mengaktifkan fitur pan
              mode: 'x', // Hanya horizontal
              threshold: 10, // Sensitivitas pan
            },
            zoom: {
              wheel: {
                enabled: false // Nonaktifkan zoom dengan scroll
              },
              pinch: {
                enabled: false // Nonaktifkan zoom dengan pinch
              },
              mode: 'x', // Zoom horizontal
            },
            limits: {
              x: {
                minRange: 4
              }, // Batas minimal data yang ditampilkan (4 data)
            }
          },
          annotation: {
            annotations: {
              tipologi1: {
                type: 'box',
                yMin: 17.5,
                yMax: 20,
                backgroundColor: 'rgba(0, 128, 0, 0.2)', // Hijau transparan
                borderWidth: 0
              },
              tipologi2: {
                type: 'box',
                yMin: 15,
                yMax: 17.5,
                backgroundColor: 'rgba(255, 255, 0, 0.2)', // Kuning transparan
                borderWidth: 0
              },
              tipologi3: {
                type: 'box',
                yMin: 10,
                yMax: 15,
                backgroundColor: 'rgba(255, 165, 0, 0.2)', // Oranye transparan
                borderWidth: 0
              },
              tipologi4: {
                type: 'box',
                yMin: 0,
                yMax: 10,
                backgroundColor: 'rgba(255, 0, 0, 0.2)', // Merah transparan
                borderWidth: 0
              }
            },
            tooltip: {
              callbacks: {
                footer: function (tooltipItems) {
                  return `Nilai: ${tooltipItems[0].parsed.y}`;
                }
              }
            },
          },
          datalabels: {
            color: '#000', // Warna label
            anchor: 'center', // Posisi label
            align: 'center', // Penyelarasan label
            formatter: (value, context) => {
              const label = context.chart.data.labels[context.dataIndex];
              return `${label}: ${value}%`; // Format teks label
            }
          }
        },
        scales: {
          x: {
            display: true,
            // min: 0, // Indeks awal data yang ditampilkan
            // max: 3, // Indeks akhir data yang ditampilkan
            min: xMin, // Indeks awal data yang ditampilkan
            max: xMax, // Indeks akhir data yang ditampilkan
            title: {
              display: true,
              text: 'Periode',
              color: 'rgba(84, 12, 173, 0.91)',
              font: {
                family: 'Open Sans',
                size: 20,
                weight: 'bold',
                lineHeight: 1.2,
              },
              padding: {
                top: 20,
                left: 0,
                right: 0,
                bottom: 0
              }
            }
          },
          y: {
            min: 0,
            max: 20,
            ticks: {
              stepSize: 1, // Pastikan interval adalah 1
              callback: function (value) {
                return value; // Tampilkan nilai seperti apa adanya
              }
            },
            suggestedMin: 0, // Mulai dari 0
            suggestedMax: 20, // Maksimal 20
            display: true,
            title: {
              display: true,
              text: 'Skor Total',
              color: 'rgba(84, 12, 173, 0.91)',
              font: {
                family: 'Open Sans',
                size: 20,
                weight: 'bold',
                lineHeight: 1.2
              },
              padding: {
                top: 30,
                left: 0,
                right: 0,
                bottom: 0
              }
            }
          }
        },
      }
    });
  }

  // Fungsi Pan dengan Tombol
  function panLeft(data) {
    if (xMin - panStep >= 0) { // Cek apakah masih bisa ke kiri
      xMin -= panStep;
      xMax -= panStep;
      updateChart(data);
    }
  }

  function panRight(data) {
    if (xMax + panStep < fullData.length) { // Cek apakah masih bisa ke kanan
      xMin += panStep;
      xMax += panStep;
      updateChart(data);
    }
  }

  // Event Listener untuk Tombol
  $('#btnPanLeft').on('click', function (e) {
    e.preventDefault();
    panLeft(fullData);
  });

  $('#btnPanRight').on('click', function (e) {
    e.preventDefault();
    panRight(fullData);
  });

  function formatPeriode(periode) {
    const tahun = periode.slice(0, 4); // Ambil 4 digit pertama (tahun)
    const kode = periode.slice(4); // Ambil digit terakhir (kode semester)

    switch (kode) {
      case '1':
        return `${tahun} Januari - Juni`;
      case '2':
        return `${tahun} Juli - November`;
      default:
        return `${tahun} Periode Tidak Valid`;
    }
  }

  // Tambahkan legenda manual untuk warna-warna annotation
  const legendContainer = document.getElementById('chartLegend');
  legendContainer.innerHTML = `
  <div class="d-flex justify-content-around">
     <div style="display: flex; align-items: center;">
       <div style="width: 20px; height: 20px; background-color: rgba(0, 128, 0, 0.2); margin-right: 10px;"></div>
       Tipologi 1: 17.5 < n ≤ 20
     </div>
     <div style="display: flex; align-items: center; margin-top: 5px;">
       <div style="width: 20px; height: 20px; background-color: rgba(255, 255, 0, 0.2); margin-right: 10px;"></div>
       Tipologi 2: 15 < n ≤ 17.5
     </div>
     <div style="display: flex; align-items: center; margin-top: 5px;">
       <div style="width: 20px; height: 20px; background-color: rgba(255, 165, 0, 0.2); margin-right: 10px;"></div>
       Tipologi 3: 10 ≤ n ≤ 15
     </div>
     <div style="display: flex; align-items: center; margin-top: 5px;">
       <div style="width: 20px; height: 20px; background-color: rgba(255, 0, 0, 0.2); margin-right: 10px;"></div>
       Tipologi 4: n < 10
     </div>
  </div>
   `;
});

function confirmDelete(id) {
  Swal.fire({
    title: "Yakin?",
    text: "Anda akan menghapus data ini!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Tidak!",
    confirmButtonText: "Yes, hapus!"
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = baseURL + "admin/hapus-kip-kuliah/" + id;
    }
  });

  // if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
  // Jika konfirmasi "Ya", kirim permintaan ke server untuk menghapus data
  // window.location.href = baseURL + "admin/hapus-kip-kuliah/" + id;
  // }
  // Jika user klik "No", tidak terjadi apa-apa, alert ditutup
}

function openEditModal(id, tahun, kuota_reguler, kuota_usulan) {
  // Isi form di modal dengan data yang ada menggunakan jQuery
  $('#edit_id').val(id);
  $('#edit_tahun').val(tahun);
  $('#edit_kuota_reguler').val(kuota_reguler);
  $('#edit_kuota_usulan').val(kuota_usulan);

  // Tampilkan modal menggunakan jQuery
  $('#editModal').modal('show');
}

// $('#import-data').click(function (event) {
//   // Mencegah aksi default tombol submit
//   event.preventDefault();

//   let periode = document.getElementById('periode').value;
//   let file = document.getElementById('exampleInputFile').value;
//   let prd = periode.substr(-1) == 1 ? ' Periode 1' : ' Periode 2';

//   if (periode === '') {
//     Swal.fire({
//       title: "Pilih periode terlebih dahulu",
//       // text: "You clicked the button!",
//       icon: "warning"
//     });
//     return false
//   }

//   if (file === '') {
//     Swal.fire({
//       title: "Pilih file terlebih dahulu",
//       // text: "You clicked the button!",
//       icon: "warning"
//     });
//     return false
//   }

//   // SweetAlert2 Konfirmasi
//   Swal.fire({
//     title: 'Import Data?',
//     text: "Apakah anda yakin ingin import data pada " + periode.substr(0, 4) + prd + "?",
//     icon: 'warning',
//     showCancelButton: true,
//     confirmButtonColor: '#3085d6',
//     cancelButtonColor: '#d33',
//     confirmButtonText: 'Ya, import!',
//     cancelButtonText: 'Batal'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       // Pilih form yang terkait dan kirim secara manual
//       const form = document.getElementById('form-import-data'); // Ganti 'your-form-id' dengan ID form Anda
//       form.submit(); // Kirim form secara manual
//     }
//   });
// });

$('#hapus-data').click(function (event) {
  // Mencegah aksi default tombol submit
  event.preventDefault();

  let periode = document.getElementById('periode-hapus').value;
  let prd = periode.substr(-1) == 1 ? ' Periode 1' : ' Periode 2';

  if (periode === '') {
    Swal.fire({
      title: "Pilih periode terlebih dahulu",
      // text: "You clicked the button!",
      icon: "warning"
    });
    return false
  }

  // SweetAlert2 Konfirmasi
  Swal.fire({
    title: 'Hapus Data ' + periode.substr(0, 4) + ' ' + prd,
    text: "Apakah anda yakin ingin hapus data",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Pilih form yang terkait dan kirim secara manual
      const form = document.getElementById('form-hapus-data'); // Ganti 'your-form-id' dengan ID form Anda
      form.submit(); // Kirim form secara manual
    }
  });
});

$('#form-import-data').on('submit', function (event) {
  let periode = document.getElementById('periode').value;
  let file = document.getElementById('exampleInputFile').value;
  let prd = periode.substr(-1) == 1 ? ' Periode 1' : ' Periode 2';

  if (periode === '') {
    event.preventDefault();
    Swal.fire({
      title: "Pilih periode terlebih dahulu",
      icon: "warning"
    });
    return;
  }

  if (file === '') {
    event.preventDefault();
    Swal.fire({
      title: "Pilih file terlebih dahulu",
      icon: "warning"
    });
    return;
  }

  // Cegah submit form langsung
  event.preventDefault();

  Swal.fire({
    title: 'Import Data?',
    text: "Apakah anda yakin ingin import data pada " + periode.substr(0, 4) + prd + "?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, import!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Gunakan native submit agar event berjalan normal
      document.getElementById('form-import-data').submit();
    }
  });
});