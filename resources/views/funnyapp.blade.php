@extends('master')
@section('style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css">
<style type="text/css">
	.wrapper-upload-image{
		margin-top: 50px;
		margin-bottom: 50px;
	}
</style>
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.js"></script>

<script type="text/javascript">
    image = jQuery('#blah');  
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);            
               
                image.cropper({     
                preview : '.img-preview',
             
                });
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function cropkk(){   
       
    }
   
    
    jQuery("#imgInp").change(function(){
        readURL(this);        
    });

    jQuery('#crop').click(function(e){
        e.preventDefault();   
        var canvas = image.cropper('getCroppedCanvas');

        canvas.toBlob(function(blob){
            var newImg = document.createElement('img'),
            url = URL.createObjectURL(blob);

            newImg.onload = function() {
                // no longer need to read the blob so it's revoked
                URL.revokeObjectURL(url);
            };

            newImg.src = url;           
            jQuery('#result').html(newImg);

            console.log(newImg);
        });


       
        
        
    });

</script>
@endsection
@endsection

@section('content')
</style>
<div class="container wrapper-upload-image">
    <div class="col-md-9">
	{{ Form::open() }}
   	<?php echo Form::file('pic',array('accept'=>'image/*','id'=>'imgInp')); ?>
   	<img id="blah" src="#" alt="image">
    <button id="crop">crop</button>
	{{ Form::close() }}
    </div>
    <div class="col-md-3">
    <div class="img-preview" style="width: 200px; height:100px;overflow: hidden;"></div>
    <div id="result"></div>
    </div>
</div>
@endsection