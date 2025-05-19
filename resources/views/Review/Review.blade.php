@extends('layouts.app')

@section('content')
    <div class="review-container">
        <div class="review-box">
            <h2 class="review-title">Rate Your Delivery Experience</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form to submit a review -->
            <form method="post" action="{{ route('reviews.store', $deliveries->id) }}">
                @csrf

                <!-- Hidden field to pass the delivery ID -->
                <input type="hidden" name="deliveries_id" value="{{ $deliveries->id }}">

                <!-- Rating Stars -->
                <div class="form-group">
                    <label for="rating">Click on stars</label>
                    <div class="star-rating" id="starRating">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}">&#9733;</span>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" required>
                </div>


                <!-- Review Textarea -->
                <div class="form-group">
                    <label for="review">Your Review</label>
                    <textarea name="review" id="review" rows="4" class="input-field"
                        placeholder="Share your experience..."></textarea>
                </div>

                <button type="submit" class="submit-button">
                    Submit Review
                </button>
            </form>
        </div>
    </div>

    @section('Review_styles')
    <style>
        /* The same styling as in your provided code */
        .review-container {
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        .review-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
        }

        .review-title {
            font-size: 1.875rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d0e9c6;
        }

        .alert-error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }

        .error-list {
            margin-left: 20px;
            list-style-type: disc;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 1rem;
            font-weight: 500;
            color: #555;
            display: block;
            margin-bottom: 0.5rem;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #f9f9f9;
            transition: all 0.3s;
        }

        .input-field:focus {
            border-color: #3498db;
            outline: none;
            background-color: #fff;
        }

        .submit-button {
            width: 100%;
            padding: 1rem;
            background-color: #3498db;
            color: #fff;
            font-size: 1.125rem;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: #2980b9;
        }

        .star-rating {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            display: flex;
            gap: 5px;
        }

        .star-rating .star.selected,
        .star-rating .star.hovered {
            color: #ffd700;
        }
    </style>
@endsection
@section('Review_script')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingInput = document.getElementById('rating');
        let selectedRating = 0;

        stars.forEach(star => {
            star.addEventListener('mouseenter', () => {
                const value = parseInt(star.getAttribute('data-value'));
                highlightStars(value);
            });

            star.addEventListener('mouseleave', () => {
                highlightStars(selectedRating);
            });

            star.addEventListener('click', () => {
                selectedRating = parseInt(star.getAttribute('data-value'));
                ratingInput.value = selectedRating;
                highlightStars(selectedRating);
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                const value = parseInt(star.getAttribute('data-value'));
                star.classList.toggle('selected', value <= rating);
            });
        }
    });
</script>
@endsection
@endsection