<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="icon" href="{{URL::asset('images/icons/favicon.ico')}}" type="image/x-icon"/>
    
    <title>Bootstrap Theme Company</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
      .jumbotron { 
          background-color: #F2F2F2; /* Orange */
          /*color: #ffffff;*/
      }

      .navbar {
          margin-bottom: 0;
          background-color: #f4511e;
          z-index: 9999;
          border: 0;
          font-size: 12px !important;
          line-height: 1.42857143 !important;
          letter-spacing: 4px;
          border-radius: 0;
      }

      .navbar li a, .navbar .navbar-brand {
          color: #fff !important;
      }

      .navbar-nav li a:hover, .navbar-nav li.active a {
          color: #f4511e !important;
          background-color: #fff !important;
      }

      .navbar-default .navbar-toggle {
          border-color: transparent;
          color: #fff !important;
      }
      .trhead
      {
        background-color: #ff6400; /* Orange */
        color: #fff;
      }
    </style>
</head>

  <body>
    <header>
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> -->
            <!--   <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span> 
            --><!-- </button> -->
            <a class="navbar-brand" href="{{route('welcome')}}">THANH TÙNG</a>
          </div>
          <!-- <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="#about">ABOUT</a></li>
              <li><a href="#services">SERVICES</a></li>
              <li><a href="#portfolio">PORTFOLIO</a></li>
              <li><a href="#pricing">PRICING</a></li>
              <li><a href="#contact">CONTACT</a></li>
            </ul>
          </div> -->
        </div>
      </nav>
    </header>

    <content>

      <div id="div-commodity-unavaliable" class="jumbotron text-center hidden">
        <br>
        <h4>SẢN PHẨM KHÔNG TỒN TẠI!</h4>
      </div>

      <div id="div-commodity-avaliable" class="jumbotron">
          <div class="panel panel-default">
            <div class="panel panel-heading"><strong> <i class="fa fa-info-circle"></i> THÔNG TIN CHUNG </strong></div>
            <div class="panel-body">
              <div class="col-md-4">
                <img src="{{URL::asset('images\product\chacatamuop.jpg')}}" class="img-thumbnail">
              </div>
              <div class="col-md-8">
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#thongtinchung">THÔNG TIN SẢM PHẨM</a></li>
                  <li><a data-toggle="tab" href="#thanhphan">THÀNH PHẦN</a></li>
                  <li><a data-toggle="tab" href="#huongdansudung">HƯỚNG DẪN SỬ DỤNG</a></li>
                </ul>

                <div class="tab-content">
                  <div id="thongtinchung" class="tab-pane fade in active">

                    <table class="table table-hover">
                      <thead>
                        <th class="text-center" colspan="2">THÔNG TIN SẢN PHẨM</th>
                      </thead>
                      <tbody>
                        <tr>
                          <th width="40%">Mã sản phẩm:</th>
                          <td width="60%" id="masanpham"></td>
                        </tr>
                        <tr>
                          <th width="40%">Tên sản phẩm:</th>
                          <td width="60%" id="tensanpham"></td>
                        </tr>
                        <tr>
                          <th width="40%">Ngày sản xuất:</th>
                          <td width="60%" id="ngaysanxuat"></td>
                        </tr>
                        <tr>
                          <th width="40%">Khối lượng:</th>
                          <td width="60%" id="khoiluong"></td>
                        </tr>
                      </tbody>
                    </table>
                    
                  </div>
                  <div id="thanhphan" class="tab-pane fade">
                    <div class="col-md-6">

                      <ul>
                        <br>
                        <li>
                          Cá Thát Lát (92%)
                        </li>
                        <br>


                        <li>
                          Thị heo
                        </li>
                        <br>


                        <li>
                          Muối
                        </li>
                        <br>


                        <li>
                          Chất điều vị (E621)
                        </li>
                        <br>


                        <li>
                          Tiêu
                        </li>
                        <br>


                        <li>
                          Hành
                        </li>
                      </ul>
                    </div>

                    <div class="col-md-6 text-center">
                      <br>

                      <img src="{{URL::asset('images/product/chebien2.jpg')}}" class="img-rounded img-thumbnail" style="width: 70%;">

                    </div>
                  </div>
                  <div id="huongdansudung" class="tab-pane fade">
                    <div class="col-md-6">
                      <ol> 
                        <br>
                        <li>
                          Rã đông tự nhiên không ngâm nước.
                        </li>
                        <br>

                        <li>
                          Đổ dầu nhiều vào chảo, đun lửa cho đến khi dầu nóng để cá vào chiên giòn.
                          
                        </li>
                        <br>

                        <li>
                          Sau khi chín, cắt cá thành từng miếng ghép thành hình cá Nàng Hai (cá Thác Lát).
                        </li>
                      </ol>
                    </div>

                    <div class="col-md-6 text-center">
                        <br>


                      <img src="{{URL::asset('images/product/chebien_tamuop1.jpg')}}" class="img-circle" style="width: 70%;">

                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="panel panel-default">
            <div class="panel panel-heading"><strong> <i class="fa fa-cubes"></i> THÔNG GIAO DỊCH </strong></div>
            <div class="panel-body">
              <table class="table table-hover table-bordered">

                <thead>
                  <th class="text-center">#</th>
                  <th class="text-center">Thời gian</th>
                  <th>Hoạt động</th>
                  <th>Thực hiện</th>
                  <th>Minh chứng</th>
                </thead>
              
                <tbody id="tbody-commodity-trace">
                  
                </tbody>

              </thead>
              </table>
            </div>
          </div>
          
      </div>

    </content>

    <footer class="container-fluid text-center">
      <!-- <a href="#myPage" title="To Top">
        <span class="glyphicon glyphicon-chevron-up"></span>
      </a> -->
      <p> <strong> CƠ SỞ SẢN XUẤT CÁ NÀNG HAI THANH TÙNG </strong> </p>
      <p> <i class="fa fa-phone-square"></i> 097 47 63367</p>
      <p> <i class="fa fa-envelope"></i> cananghaithanhtung@gmail.com</p>
      <p> <i class="fa fa-map-marker"></i> Tổ 10, Ấp Bình Thành, Xã Phú Bình, Huyện Phú Tân, Tỉnh An Giang, Việt Nam</p>
      <p> <i class="fa fa-copyright"></i> HỆ THỐNG ĐƯỢC PHÁT TRIỂN BỞI IBLAB AGU - ĐƯỢC TÀI TRỢ BỞI IBL VIỆT NAM</p>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="{{URL::asset('js/global.js')}}"></script>
    <script src="{{URL::asset('js/trace.js')}}"></script>

    <script type="text/javascript">

      var commodityID = "{{request()->route('id')}}";

      showCommodityTrace(commodityID);
      // getDistributorAPI();
      // getDistributorAPIForDistributor();
      // getRetailerAPIForDistributor();
    </script>


  </body>
</html>