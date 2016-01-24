<?php //echo '<pre>';die(print_r($data)); ?>
<div class="breadcrumbwidget">
	<ul class="skins">
        <li><a href="default" class="skin-color default"></a></li>
        <li><a href="orange" class="skin-color orange"></a></li>
        <li>&nbsp;</li>
        <li class="fixed"><a href="" class="skin-layout fixed"></a></li>
        <li class="wide"><a href="" class="skin-layout wide"></a></li>
    </ul><!--skins-->
	<ul class="breadcrumb">
        <li><a href="<?php echo $baseurl?>">Trang chủ</a> <span class="divider">/</span></li>
        <li class="active">Danh sách người dùng</li>
    </ul>
</div><!--breadcrumbwidget-->
<div class="pagetitle">
	<h1>Danh sách người dùng</h1> <span></span>
</div>
<div class="maincontent">
    <div class="contentinner">    
        <?php $attr = array('class' => 'stdform','id' => 'form-list','method' => 'get'); echo form_open('', $attr);?>
        <div id="filter" class="dataTables_length">
		<a href="<?php echo $baseurl.'nguoi-dung/them-nguoi-dung'?>" class="btn"><i class="icon-plus"></i> Thêm mới</a>
            <input id="txtsearch" type="text" value="<?php echo @$txtsearch;?>" name="txtsearch" placeholder="Nhập từ khóa" style="padding: 6px 5px; background-color: #fff; font-size: 12px;"/>
            <button type="submit" class="btn btn-success">Tìm kiếm</button>
        </div>
        </form>
    	<table class="table table-bordered">
            <colgroup>
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
            </colgroup>
            <thead>
                <tr>
                
                    <th style="">Tài khoản</th>
					<th style="">Họ tên</th>
					<th>Email</th>
					<th>Điện thoại</th>
                    <th>Trạng thái</th>
                    <th class="centeralign" style="width: 10%">Tác vụ</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!in_array($data['data'], array(null, '', '0'))):?>
            <?php
                $i = 1;
             foreach($data['data'] AS $el=>$le):
            ?>
                <tr>
              
                   <td>
                       <?php echo $fview->printstr($le->tenDangNhap,100);?>
                    </td>
					<td>
						<?php echo $le->hoTen;?>
                    </td>
					<td>
                       <?php echo $le->diaChiEmail; ?>
					   
                    </td>
                   <td><?php echo $le->soDienThoai;?></td>
				 
					<td>
                       <?php echo $fview->convertActive($le->kichHoat);?>
                    </td>
                    <td class="centeralign">
                        <a href="<?php echo $baseurl.'nguoi-dung/sua-nguoi-dung/'.$le->maNguoiDung?>" class=""><span class="icon-edit"></span></a>
                        <a href="<?php echo $baseurl.'nguoi-dung/xoa-nguoi-dung/'.$le->maNguoiDung?>" class="delete-a"><span class="icon-trash"></span></a>   
                    </td>
                </tr>
            <?php endforeach;?>
            <?php endif?>
            </tbody>
        </table>
        <div class="dataTables_info" id="dyntable_info">
            <div class="pagination">
                <?php echo $this->pagination->create_links();?> 
            </div>
        </div>
        </form>
    </div>
</div>
<style>
.table th, .table td {
vertical-align: middle !important;
}
</style>