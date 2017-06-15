<html>
    <head>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    </head>
    <body>
<p>time : <span id="time"></span></p>
<form class="recmd">
<div class="div_click" style="margin:100px;width:100px;height:100px;background-color:red">
<input type="hidden" name="seq" value="58" />

<input type="button" class="execute"  value="execute" />
</div>
</form>
    </body>
</html>


        
<script>
    $('body').click(function(){
        $.ajax({
            url:'./time.php?what=2',
            type:'post',
            data:$('.recmd').serialize(),
            success:function(data){
                $('#time').text(data);
            }
        })
    })
</script>

