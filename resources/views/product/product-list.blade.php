@extends('layouts.master')
@section('title', 'Products')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row mb-2 -->
      </div><!-- /.container-fluid -->
    </div> <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
	          	<div class="col-lg-12">

		          	<div class="card card-primary">
		              <div class="card-header">
		                	<h5 class="m-0"><strong>PRODUCTS</strong></h5>
		              </div>
		              <div class="card-body">
	                	<a href="/product-create"><button type="button" class="btn btn-outline-info"><i class="fas fa-plus"></i> Create Product</button></a>
	                    <div class="pt-3">
                            <table id="product_table" class="display" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <!--  <th>MRP</th>
                                        <th>Purchase Cost</th>
                                        <th>Inventory Stock</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <!--  <tbody class="tbodyp">

                                </tbody> -->
                            </table>
                        </div>

		              </div> <!-- Card-body -->
		            </div>	<!-- Card -->

		        </div>   <!-- /.col-lg-6 -->
        	</div><!-- /.row -->
        </div> <!-- container-fluid -->
    </div> <!-- /.content -->
</div> <!-- /.content-wrapper -->

@endsection

@section('script')
<script type="text/javascript" src="js/product.js"></script>
<script type="text/javascript">

</script>

@endsection



