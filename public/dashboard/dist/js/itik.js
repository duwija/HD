$(".plan-delete").on("click", function(e) {
    e.preventDefault();
    Swal.fire({
	  title: 'Are you sure?',
	  text: "You want to delete this Item!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
	  if (result.value) {
	    $(this).closest('form').submit();
	  }
	})
});

$(".distpoint-delete").on("click", function(e) {
    e.preventDefault();
    Swal.fire({
	  title: 'Are you sure?',
	  text: "You want to delete this Item!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
	  if (result.value) {
	    $(this).closest('form').submit();
	  }
	})
});

$(".invoice-delete").on("click", function(e) {
    e.preventDefault();
    Swal.fire({
	  title: 'Are you sure?',
	  text: "You want to delete this Item!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
	  if (result.value) {
	    $(this).closest('form').submit();
	  }
	})
});

$(".invoice-cancel").on("click", function(e) {
    e.preventDefault();
    Swal.fire({
	  title: 'Are you sure?',
	  text: "You want cancel this invoice!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then((result) => {
	  if (result.value) {
	    $(this).closest('form').submit();
	  }
	})
});

$(".invoice-bulk").on("click", function(e) {
    e.preventDefault();
    Swal.fire({
	  title: 'Are you sure?',
	  text: "You Want Create Multiple Mounthly Invoice ?!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then((result) => {
	  if (result.value) {
	   location.href = 'invoice/bulk';
	  }
	})
});


$(".invoice-verify").on("click", function(e) {
    e.preventDefault();
    Swal.fire({
	  title: 'You want Verify this transaction?',
	  text: "",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then((result) => {
	  if (result.value) {
	    $(this).closest('form').submit();
	  }
	})
});


//Site

$(".site-delete").on("click", function(e) {
    e.preventDefault();
    Swal.fire({
	  title: 'Are you sure?',
	  text: "You want to delete this Item!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
	  if (result.value) {
	    $(this).closest('form').submit();
	  }
	})
});


//Site
// $(".pushbutton").on("click", function(e) {
// 	 var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

// 	 $.ajax({
//                     /* the route pointing to the post function */
//                     url: '/postajax',
//                     type: 'POST',
//                     /* send the csrf-token and the input to the controller */
//                     data: {_token: CSRF_TOKEN, message:$(".getinfo").val()},
//                     dataType: 'JSON',
//                     /* remind that 'data' is the response of the AjaxController */
//                     success: function (data) { 
//                        // $(".writeinfo").append(data.msg); 
//                          alert(data.success);
//                     }
//                 }); 
// });


$(".item-delete").on("click", function(e) {
    e.preventDefault();
    Swal.fire({
	  title: 'Are you sure?',
	  text: "You want to delete this Item!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
	  if (result.value) {
	    $(this).closest('form').submit();
	  }
	})
});

