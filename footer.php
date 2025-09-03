<!--Navbar end here -->
<footer>
    <p>Copyright © <?php echo date('Y'); ?> Design and Developed by <span style="color: #091057; letter-spacing: 1.7px;"><b>ArsaSoftTech</b></span></p>
</footer>
<!--ck editor -->
<script src="ckeditornew/ckeditor.js"></script>
<!--ck editor -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
     new DataTable('#example', {
        layout: {
            topStart: {
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                pageLength: {
                    menu: [[10, 20, 50, 100, -1], [10, 20, 50, 100, "All"]]
                }
            },
            topEnd: {
                search: { placeholder: 'Search...' }
            },
            bottomStart: 'info',
            bottomEnd: 'paging'
        }
    });
//     new DataTable('#example', {
//     layout: {
//         topStart: {
//             buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
//         }
//     }
// });
</script>
<script src="js/custom.js"></script>
</body>
</html>