<?php include('admin/db_connect.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 5%;
      font-family: Arial, sans-serif;
      background-color: #DBDCD7;
    }

    .slider {
      position: relative;
      width: 100%;
      height: 400px;
      overflow: hidden;
    }

    .slider img {

      position: absolute;
      width: 100%;
      height: 400px;
      object-fit: contain;
      opacity: 0;
      transition: opacity 3s;
    }

    .slider img:first-child {
      opacity: 1;
    }

    .slider button {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(0, 0, 0, 0.5);
      color: #fff;
      font-size: 2rem;
      padding: 0.5rem 1rem;
      border: none;
      cursor: pointer;
    }

    .slider-container {
      position: relative;
    }

    .button-container {
      position: absolute;
      top: 50%;
      left: 0;
      width: 100%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
    }

    .prev,
    .next {
      background-color: transparent;
      border: none;
      cursor: pointer;
      font-size: 24px;
    }
  </style>
</head>

<body>
  <?php
  $sql = "SELECT image_url FROM images";
  $res = $conn->query($sql);

  if ($res === FALSE) {
    echo "Error fetching images: " . $conn->error;
  } else {
    if (mysqli_num_rows($res) > 0) {
      echo '<div class="slider-container">';
      echo '<div class="slider">';
      while ($images = mysqli_fetch_assoc($res)) {
        echo '<div class="alb">';
        $image_url = './uploads/' . $images['image_url'];
        echo '<img src="' . $image_url . '" />';
        echo '</div>';
      }
      echo '</div>';
      echo '<div class="button-container">';
      echo '<button class="prev" onclick="prevSlide()">&#10094;</button>';
      echo '<button class="next" onclick="nextSlide()">&#10095;</button>';
      echo '</div>';
      echo '</div>';
    } else {
      echo "No images found.";
    }
  } ?>

  </div>
  <br>
  <script>
    let currentIndex = 0;

    function prevSlide() {
      currentIndex--;
      if (currentIndex < 0) {
        currentIndex = document.querySelectorAll('.slider img').length - 1;
      }
      showSlide(currentIndex);
    }

    function nextSlide() {
      currentIndex++;
      if (currentIndex >= document.querySelectorAll('.slider img').length) {
        currentIndex = 0;
      }
      showSlide(currentIndex);
    }

    function showSlide(index) {
      const slides = document.querySelectorAll('.slider img');

      slides.forEach(slide => {
        slide.style.opacity = 0;
      });
      slides[index].style.opacity = 1;
    }

    setInterval(nextSlide, 5000);
  </script>
</body>

</html>

<div class="col-lg-12">
  <div class="row">
    <div class="col-md-3">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title">Categories</h3>
          <div class="card-tools">
            <!--  <button type="button" class="btn btn-tool" data-card-widget="card-refresh" data-source="widgets.html" data-source-selector="#card-refresh-content">
                <i class="fas fa-sync-alt"></i>
              </button> -->
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <ul class="list-group">
            <?php
            $category = $conn->query("SELECT * FROM categories order by name asc");
            while ($row = $category->fetch_assoc()) :
              $cname[$row['id']] =  ucwords($row['name']);
            ?>
              <li class="list-group-item">
                <div class="icheck-primary d-inline">
                  <input type="checkbox" id="chk<?php echo $row['id'] ?>" class="cat-filter" value="<?php echo $row['id'] ?>">
                  <label for="chk<?php echo $row['id'] ?>"><small><?php echo ucwords($row['name']) ?></small></label>
                </div>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9 border-left">
      <div class="container-fluid">
        <div class="col-md-12">
          <div class="input-group">
            <input type="search" id="filter" class="form-control form-control-lg" placeholder="Type your keywords here">
            <div class="input-group-append">
              <button type="button" id="search" class="btn btn-lg btn-default">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
          <div class="row">
            <?php
            $products = $conn->query("SELECT
            p.*,
            COALESCE(s.size, 0) AS lowest_size,
            COALESCE(s.price, 0) AS lowest_price
        FROM
            products p
        LEFT JOIN sizes s ON p.id = s.product_id
        LEFT JOIN (
            SELECT
                product_id,
                MIN(price) AS min_price
            FROM
                sizes
            GROUP BY
                product_id
        ) t ON s.product_id = t.product_id AND s.price = t.min_price
        GROUP BY
            p.id ORDER BY rand();
        ");
            while ($row = $products->fetch_assoc()) :
              $img = array();
              if (isset($row['item_code']) && !empty($row['item_code'])) :
                if (is_dir('assets/uploads/products/' . $row['item_code'])) :
                  $_fs = scandir('assets/uploads/products/' . $row['item_code']);
                  foreach ($_fs as $k => $v) :
                    if (is_file('assets/uploads/products/' . $row['item_code'] . '/' . $v) && !in_array($v, array('.', '..'))) :
                      $img[] = 'assets/uploads/products/' . $row['item_code'] . '/' . $v;
                    endif;
                  endforeach;
                endif;
              endif;
              $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
              unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
              $desc = strtr(html_entity_decode($row['description']), $trans);
              $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
            ?>
              <a class="prod-item text-dark" href="./index.php?page=view_product&c=<?php echo $row['item_code'] ?>" target="_blank" data-cat='<?php echo $row['category_id'] ?>'>
                <div class="card my-1 mx-1 solid " style="width: 12rem;">
                  <div class="card-img-top item-img d-flex justify-content-center align-items-center">
                    <img class="card-img-top" src="<?php echo isset($img[0]) ? $img[0] : '' ?>" alt="Product Image">
                  </div>
                  <div class="card-body border-top border-info">
                    <h6 class="card-title"><?php echo $row['name'] ?></h6><br>
                    <p class="mb-2 text-muted"><small><?php echo isset($cname[$row['category_id']]) ? $cname[$row['category_id']] : '' ?></small></p>
                    <p class="card-text truncate"><?php echo strip_tags($desc) ?></p>
                    <p class="text-info"><b>PHP <?php echo number_format($row['lowest_price'], 2) ?></b></p>
                  </div>
                </div>
                <span class="d-flex bg-info">
                </span>
              </a>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .item-img {
    height: 13rem;
    overflow: hidden;
  }
</style>
<script>
  $(document).ready(function() {
    $('.slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 2000,
      dots: true,
      arrows: true
    });
  });
</script>
<script>
  $('.prod-item').hover(function() {
    $(this).find('.card').addClass('border border-info');
  });

  $('.prod-item').mouseleave(function() {
    $(this).find('.card').removeClass('border border-info');
  });

  $('.cat-filter').change(function() {
    _search();
  });

  function _search() {
    let _f = $('#filter').val()

    _f = _f.toLowerCase();
    $('.prod-item').each(function() {
      let txt = $(this).text().toLowerCase();

      if (txt.includes(_f) == true) {
        if ($('.cat-filter:checked').length > 0) {
          if ($('.cat-filter[value="' + $(this).attr('data-cat') + '"]').prop('checked') == true) {
            $(this).toggle(true);
          } else {
            $(this).toggle(false);
          }
        } else {
          $(this).toggle(true);
        }
      } else {
        $(this).toggle(false);
      }
    });
  }

  $('#search').click(function() {
    _search();
  });

  $('#filter').on('keypress', function(e) {
    if (e.which == 13) {
      _search();
      return false;
    }
  });

  $('#filter').on('search', function() {
    _search();
  });
</script>