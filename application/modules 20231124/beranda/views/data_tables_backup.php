<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DataTables Server-Side</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <table id="dataTables" class="table table-striped table-bordered">
        <thead>
            <tr style="background-color: chartreuse;">
                <th>NIDN</th>
                <th>NAMA</th>
                <th>NAMA PT</th>
                <th>NAMA PRODI</th>
                <th>NAMA JAFUNG</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr style="background-color: chartreuse;">
                <th><input type="text" name="nidn" placeholder="Search NIDN" /></th>
                <th><input type="text" name="nama" placeholder="Search NAMA" /></th>
                <th><input type="text" name="nm_pt" placeholder="Search NAMA PT" /></th>
                <th><input type="text" name="nm_prodi" placeholder="Search NAMA PRODI" /></th>
                <th><input type="text" name="nm_jabatan" placeholder="Search NAMA JAFUNG" /></th>
            </tr>
        </tfoot>
    </table>

    <script>
        $(document).ready(function() {
            var dataTable = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?= base_url('beranda/DataTablesController/data'); ?>",
                    type: "POST"
                },
                order: [
                    [2, "asc"]
                ],
                columns: [{
                        "data": "nidn"
                    },
                    {
                        "data": "nama"
                    },
                    {
                        "data": "nm_pt"
                    },
                    {
                        "data": "nm_prodi"
                    },
                    {
                        "data": "nm_jabatan"
                    }
                ],
                initComplete: function() {
                    this.api().columns().every(function() {
                        var that = this;

                        $('input', this.footer()).on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }
            });

            console.log("DataTables initialized");

        });
    </script>
</body>

</html>