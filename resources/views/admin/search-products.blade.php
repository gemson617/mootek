<?php if(isset($prodArr)){ ?>

<div class="card ">
        <div class="card-header">
            Search Results
        </div>
        <div class="card-body">
            <div class="table-responsive" >
            <table id="example" class="table table-striped table-bordered" style="width: 100%; margin-top: 12px;" >
                    <thead  style="background-color:#3378b2; padding:3px; border-radius:5px; color:#fff; font-size:14px;">
                        <tr>
                             <th style="color:white;" class="text-capitalize">Code</th>
                            <th style="color:white;" class="text-capitalize">Name</th>
                            <th style="color:white;" class="text-capitalize">Type</th>
                            <th style="color:white;" class="text-capitalize">Category</th>
                            <th style="color:white;" class="text-capitalize">RRP Price (Exc. GST)</th>
                            <th style="color:white;" class="text-capitalize">Cost (Exc. GST)</th>
                            <th style="color:white;" class="text-capitalize">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($prodArr !=null)
                        {
                            foreach($prodArr as $key=>$row)
                            { 
                                ?>
                                <tr  style="text-transform: uppercase;"  role="row" class="odd">
                                    <td><?php echo $row['product_code']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>
                                    @if($row['type']==1)
                                        CYLINDER
                                        @elseif($row['type']==2)
                                        HARDGOOD RENTAL
                                        @elseif($row['type']==3)
                                        HARDGOOD SALES
                                        @elseif($row['type']==4)
                                        TRANSACTION
                                        @elseif($row['type']==5)
                                        GAS
                                        @endif
                                    </td>
                                    <td><?php echo isset($row['category_name']) ? $row['category_name'] : 'N/A'; ?></td>
                                    <td><?php echo  isset($row['rrp']) && $row['rrp'] != '' ? '$'.number_format($row['rrp'],2) : 'N/A'; ?></td>
                                    <td><?php echo isset($row['cost_price']) && $row['cost_price'] != '' ? '$'.number_format($row['cost_price'],2) : 'N/A'?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary ">
                                        <a href="{{route('inventory.product.view',$row['id'])}}" class="text-white">
                                            <i class="fa fa-eye fa-sm"></i>
                                        </a></button>
                                        @permission('edit-product-details')
                                        <a  href="javascript:void(0)"  onclick="edit_product_name('<?php echo $row['id']; ?>')" type="button" class="btn btn-sm btn-success">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        @endpermission
                                        <a href="javascript:void(0)" type="button" onclick="delete_product_category('<?php echo $row['id']; ?>')"
                                            class="btn btn-sm btn-danger">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                            } 
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php } ?>
