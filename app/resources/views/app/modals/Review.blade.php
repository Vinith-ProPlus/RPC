<style>
    .stars {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stars i {
        color: black;
        font-size: 25px;
        align-items: center;
        justify-content: space-evenly;
        text-shadow: 1px 1px 0.2px black;
        cursor: pointer;
    }

    .sactive {
        color: gold !important;
        transform: scale(1.2) !important;
    }

</style>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
/>
<div class="row">
    <div class="col-sm-12 mt-20">
        <div class="form-group">
            <label class="txtRstar">Rating <span class="required">*</span></label>
            <div class="stars w-25">
                <i class="fa-solid fa-star sactive" data-value="1"></i>
                <i class="fa-solid fa-star" data-value="2"></i>
                <i class="fa-solid fa-star" data-value="3"></i>
                <i class="fa-solid fa-star" data-value="4"></i>
                <i class="fa-solid fa-star" data-value="5"></i>
            </div>
            <div class="errors Review err-sm" id="txtRstar-err"></div>
        </div>
    </div>

    <div class="col-sm-12 mt-20">
        <div class="form-group mb-0">
            <label for="txtRdescription">Description <span class="required"> * </span></label>
            <textarea class="form-control" placeholder="Description" id="txtRdescription" rows="2"></textarea>
            <span class="errors Review err-sm" id="txtRdescription-err"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-right">
            <button class="btn btn-sm btn-outline-dark" id="btnReviewMClose">Close</button>
            <button class="btn btn-sm btn-outline-success" data-order-id="{{ $data['ID'] }}" id="btnSaveReview">Review
            </button>
        </div>
    </div>
    <div class="d-none" style="display: none !important;">
        <button id="btnReviewModalInit"></button>
    </div>
</div>
<script>
    var stars = document.querySelectorAll(".stars  i");

    stars.forEach((star, index1) => {
        star.addEventListener("mouseover", () => {
            stars.forEach((star, index2) => {
                index1 >= index2
                    ? (star.style.transform = "scale(1.2)")
                    : (star.style.transform = "scale(1)");
            });
            star.style.transform = "scale(1.5)";
        });
        star.addEventListener("mouseout", () => {
            star.style.transform = "scale(1)";
        });
        star.addEventListener("click", () => {
            stars.forEach((star, index2) => {
                index1 >= index2
                    ? star.classList.add("sactive")
                    : star.classList.remove("sactive");
            });
        });
    });

    $(document).ready(function () {

        $('#btnReviewModalInit').trigger('click');

    });
</script>
