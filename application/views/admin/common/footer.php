<!-- Begin: Page Footer -->
<footer id="content-footer" class="affix">
    <div class="row">
        <div class="col-md-6">
            <span class="footer-legal">&copy; <?php echo date('Y') ;?> - <?php echo date('Y', strtotime('+1 year')); ?> Admin web team</span>
        </div>
        <div class="col-md-6 text-right">
            <span class="footer-meta"><b></b></span>
            <a href="#content" class="footer-return-top">
                <span class="fa fa-arrow-up"></span>
            </a>
        </div>
    </div>
</footer>

<div class="modal" id="globalModal"  role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="loader">
                    <div class="es-spinner">
                        <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End: Page Footer -->

</section>
<!-- End: Content-Wrapper -->
</div>

<script src="<?php echo $this->config->item('admin_js');?>utility/utility.js"></script>
<script src="<?php echo $this->config->item('admin_js');?>main.js"></script>

<!-- PNotify -->
<script src="<?php echo $this->config->item('admin_js');?>plugins/pnotify/pnotify.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        "use strict";
        // Init Theme Core
        Core.init();

        var Stacks = {
            stack_top_right: {
                "dir1": "down",
                "dir2": "left",
                "push": "top",
                "spacing1": 10,
                "spacing2": 10
            },
            stack_bar_top: {
                "dir1": "down",
                "dir2": "right",
                "push": "top",
                "spacing1": 0,
                "spacing2": 0
            }
        };

        // PNotify Plugin Event Init
        $('.notification').on('click', function(e) {
            var noteStyle = $(this).data('note-style');
            var noteStack = $(this).data('note-stack');
            var noteText = $(this).html();

            // If notification stack or opacity is not defined set a default
            var noteStack = noteStack ? noteStack : "stack_top_right";

            // We modify the width option if the selected stack is a fullwidth style
            function findWidth() {
                if (noteStack == "stack_bar_top") {
                    return "100%";
                }
                if (noteStack == "stack_bar_bottom") {
                    return "70%";
                } else {
                    return "auto";
                }
            }
            // Create new Notification
            new PNotify({
                title: false,
                text: noteText,
                addclass: noteStack,
                type: noteStyle,
                stack: Stacks[noteStack],
                width: findWidth(),
                delay: 1400,
                insert_brs: false
            });

        });
        $(function(){
            $('.confirm-alert').click(function(){
                return confirm("Are you sure to perform this action?");
            });
        });

    });
</script>
</body>
</html>