<div id="embedPrintDiv"><?php echo $invoice; ?></div>
<script>
    printDiv();
    function printDiv() {
        var divToPrint = document.getElementById('embedPrintDiv');
        newWin = window.open("");
        newWin.document.write(divToPrint.innerHTML);
        newWin.print();
        newWin.close();
    }
</script>
<style>
    #embedPrintDiv { width:100%;}
</style>


