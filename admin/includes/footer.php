</div> <!-- End of wrapper -->

<footer class="footer mt-auto py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="text-muted">© <?php echo date('Y'); ?> Luna. All rights reserved.</span>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery (required for Toastr and DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr JS (must come after jQuery) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- DataTables Responsive JS -->
<!-- <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script> -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/dashboard.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize DataTable with error handling
    if ($('#table-data').length) {
        $('#table-data').DataTable({
            responsive: true,
            pageLength: 10,
            lengthChange: false,
            columnDefs: [
                { orderable: false, targets: -1 } // Disable sorting on "Actions" column
            ],
            dom: '<"row"<"col-12 col-md-6"l><"col-12 col-md-6 text-end"f>>t<"row mt-3"<"col-12 col-md-6"i><"col-12 col-md-6 text-end"p>>',
            language: {
                paginate: {
                    previous: '<i class="fas fa-angle-left"></i>',
                    next: '<i class="fas fa-angle-right"></i>'
                }
            },
            initComplete: function (settings, json) {
                $(this).closest('.dataTables_wrapper').find('.dataTables_filter input').addClass('form-control');
            }
        });
    } else {
        console.error('Table with id "table-data" not found.');
    }

    // Initialize Toastr options
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: '5000'
    };

    // Test notification (optional, for debugging)
    // toastr.info('This is a test toast message');

    // Log for debugging
    console.log('jQuery:', typeof jQuery); // Verify jQuery is loaded
    console.log('Toastr test:', typeof toastr);
    console.log('Session success:', <?= json_encode($_SESSION['success'] ?? null) ?>);
    console.log('Session error:', <?= json_encode($_SESSION['error'] ?? null) ?>);

    // Display session-based notifications
    <?php if (isset($_SESSION['success'])): ?>
        toastr.success("<?= addslashes($_SESSION['success']) ?>");
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        toastr.error("<?= addslashes($_SESSION['error']) ?>");
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
});
</script>

</body>
</html>