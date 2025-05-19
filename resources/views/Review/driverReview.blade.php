@extends('layouts.app')

@section('content')
<div class="container mx-auto px-8 py-12">
    <h2 class="text-5xl font-extrabold text-center text-gray-900 mb-12 tracking-tight leading-tight">
        Customer Reviews for Driver
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
        @forelse($reviews as $review)
            <div class="review-card transform hover:scale-105 transition-all duration-500 ease-in-out rounded-xl bg-white shadow-2xl p-8 mb-12 border-l-8 border-indigo-500 hover:shadow-xl hover:border-indigo-600">
                <div class="flex items-center justify-between mb-6">
                    <div class="client-name text-2xl font-semibold text-gray-800 tracking-wide hover:text-indigo-700 transition-colors duration-300">
                     Client Name:{{ $review->client->first_name . ' ' . $review->client->last_name ?? 'Anonymous' }}
                    </div>
                    <div class="rating flex items-center space-x-1 text-yellow-500">
                        @for ($i = 0; $i < $review->rating; $i++)
                            <span class="text-3xl">★</span>
                        @endfor
                        @for ($i = $review->rating; $i < 5; $i++)
                            <span class="text-3xl text-gray-300">☆</span>
                        @endfor
                    </div>
                </div>

                @if($review->review)
                    <p class="review-text text-xl text-gray-700 italic mb-6 leading-relaxed">
                        "{{ $review->review }}"
                    </p>
                @endif

                <div class="review-meta flex items-center justify-between">
                    <p class="date text-sm text-gray-500 font-medium">
                        {{ $review->created_at->diffForHumans() }}
                    </p>
                    <div class="likes flex items-center space-x-2 text-sm text-gray-500 font-medium">
                        <i class="fas fa-thumbs-up text-gray-400"></i>
                        <span>{{ $review->likes_count }} Likes</span>
                    </div>
                </div>
            </div>
        @empty
            <p class="no-reviews text-center text-gray-500 font-medium text-lg">
                No reviews found for this driver.
            </p>
        @endforelse
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Custom Styling for Review Card */
    .review-card {
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 24px;
        border-radius: 20px;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        transition: all 0.3s ease-in-out;
    }

    .review-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .client-name {
        font-weight: 600;
        color: #333;
        letter-spacing: 0.5px;
    }

    .client-name:hover {
        color: #4c51bf;
    }

    .rating {
        font-size: 1.5rem;
    }

    .review-text {
        color: #4b5563;
        font-size: 1.125rem;
        font-style: italic;
        line-height: 1.6;
        font-family: 'Georgia', serif;
    }

    .review-meta {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .likes {
        display: flex;
        align-items: center;
        color: #9ca3af;
        font-weight: 600;
    }

    .likes i {
        font-size: 1.125rem;
        transition: color 0.3s ease;
    }

    .likes:hover i {
        color: #4c51bf;
    }

    .no-reviews {
        font-size: 1.125rem;
        color: #9ca3af;
        font-weight: 500;
        margin-top: 32px;
    }

    /* Animation for fade-in effect */
    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Gradient Header */
    h2 {
        background: linear-gradient(45deg, #6a11cb, #2575fc);
        -webkit-background-clip: text;
        color: transparent;
        font-size: 2.5rem;
    }

    /* Make sure the grid layout adapts well */
    @media (min-width: 640px) {
        .grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 768px) {
        .grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>
@endsection
