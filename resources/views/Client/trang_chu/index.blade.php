@extends('layouts.app')

@section('title', 'Trang chủ - Travelloula')

@section('content')

@php
    $favoriteTourIds = $favoriteTourIds ?? [];
    $homeReviews = $homeReviews ?? collect();
    $reviewStatsByTour = $reviewStatsByTour ?? collect();
    $totalReviews = $totalReviews ?? 0;
    $avgRating = (float) ($avgRating ?? 0);
@endphp

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }

    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f8fbff;
        color: #0f172a;
    }

    a {
        text-decoration: none;
    }

    .home-container,
    .hero-content {
        width: min(1680px, calc(100% - clamp(28px, 5vw, 120px)));
        max-width: 1680px;
        margin-left: auto;
        margin-right: auto;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .home-hero-static {
        min-height: clamp(520px, 40vw, 720px);
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        padding: clamp(54px, 6vw, 92px) 0;
        background: #0f172a;
    }

    .hero-static-image {
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    .hero-static-image::after {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                90deg,
                rgba(3, 28, 72, .88) 0%,
                rgba(3, 37, 92, .64) 42%,
                rgba(2, 6, 23, .18) 72%,
                rgba(2, 6, 23, .08) 100%
            ),
            linear-gradient(
                180deg,
                rgba(15, 23, 42, .10),
                rgba(15, 23, 42, .28)
            );
    }

    .hero-static-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .home-hero-static .hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #fff;
    }

    .hero-copy {
        max-width: 820px;
    }

    .hero-content h1 {
        font-size: clamp(40px, 4.2vw, 70px);
        font-weight: 900;
        line-height: 1.1;
    }

    .hero-content h2 {
        margin: 8px 0 16px;
        color: #ffd629;
        font-size: clamp(31px, 3.6vw, 58px);
        font-weight: 900;
        font-style: italic;
    }

    .hero-content h2 i {
        margin-left: 20px;
        color: #fff;
        font-size: .72em;
    }

    .hero-content p {
        margin-bottom: 34px;
        font-size: clamp(16px, 1.25vw, 21px);
        font-weight: 500;
    }

    /* =========================================================
       SEARCH
    ========================================================= */

    .search-box {
        width: 100%;
        display: grid;
        grid-template-columns:
            minmax(220px, 1.25fr)
            minmax(170px, 1fr)
            minmax(180px, 1fr)
            minmax(140px, .8fr)
            minmax(180px, .9fr);
        align-items: center;
        overflow: hidden;
        color: #0f172a;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, .22);
    }

    .search-item {
        min-width: 0;
        padding:
            clamp(17px, 1.6vw, 25px)
            clamp(18px, 1.7vw, 30px);
        display: flex;
        align-items: center;
        gap: 16px;
        border-right: 1px solid #e5e7eb;
    }

    .search-item > div {
        min-width: 0;
        width: 100%;
    }

    .search-item i {
        flex: 0 0 auto;
        color: #0757d8;
        font-size: 22px;
    }

    .search-item label {
        display: block;
        margin-bottom: 7px;
        font-size: 15px;
        font-weight: 900;
    }

    .search-item input {
        width: 100%;
        min-width: 0;
        border: 0;
        outline: 0;
        background: transparent;
        color: #64748b;
        font-size: 15px;
        font-weight: 600;
    }

    .search-btn {
        height: 64px;
        margin: 12px;
        border: 0;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        cursor: pointer;
        color: #fff;
        background: linear-gradient(135deg, #0757d8, #0044c7);
        font-size: 18px;
        font-weight: 900;
        transition: .25s ease;
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(37, 99, 235, .35);
    }

    /* =========================================================
       STATS
    ========================================================= */

    .stats-wrap {
        position: relative;
        z-index: 5;
        margin-top: -72px;
    }

    .stats-box {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        padding:
            clamp(22px, 2vw, 34px)
            clamp(18px, 2.4vw, 42px);
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, .14);
    }

    .stat-item {
        min-width: 0;
        padding: 0 clamp(15px, 2vw, 34px);
        display: flex;
        align-items: center;
        gap: 18px;
        border-right: 1px solid #e5e7eb;
    }

    .stat-item:last-child {
        border-right: 0;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        flex: 0 0 60px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        color: #0757d8;
        background: #eff6ff;
        font-size: 26px;
    }

    .stat-item h3 {
        color: #0757d8;
        font-size: clamp(24px, 2vw, 34px);
        font-weight: 900;
    }

    .stat-item p {
        color: #334155;
    }

    /* =========================================================
       SECTION
    ========================================================= */

    .home-section {
        padding: 70px 0 0;
    }

    .section-head {
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .section-head h2 {
        padding-left: 18px;
        border-left: 5px solid #0757d8;
        font-size: 30px;
        font-weight: 900;
    }

    .section-head a {
        color: #0f172a;
        font-weight: 700;
        white-space: nowrap;
    }

    .section-head a:hover {
        color: #0757d8;
    }

    /* =========================================================
       TOUR
    ========================================================= */

    .tour-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: clamp(20px, 2vw, 32px);
        align-items: stretch;
    }

    .tour-card {
        min-width: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e8eef7;
        border-radius: 18px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, .10);
        transition:
            transform .3s ease,
            box-shadow .3s ease;
    }

    .tour-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 55px rgba(15, 23, 42, .15);
    }

    .tour-card-clickable {
        cursor: pointer;
    }

    .tour-card-clickable:focus-visible {
        outline: 3px solid rgba(7, 87, 216, .25);
        outline-offset: 4px;
    }

    .tour-img {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: #eef2f7;
    }

    .tour-img img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .4s ease;
    }

    .tour-card:hover .tour-img img {
        transform: scale(1.07);
    }

    .discount {
        position: absolute;
        top: 14px;
        left: 14px;
        z-index: 4;
        max-width: calc(100% - 75px);
        padding: 7px 12px;
        overflow: hidden;
        color: #0f172a;
        background: #ffd629;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* FAVORITE */

    .home-favorite-form {
        position: absolute !important;
        top: 13px !important;
        right: 13px !important;
        z-index: 20 !important;
        width: 38px;
        height: 38px;
        margin: 0 !important;
        padding: 0 !important;
    }

    .heart {
        width: 38px;
        height: 38px;
        min-width: 38px;
        min-height: 38px;
        padding: 0;
        border: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #0757d8;
        background: #fff;
        box-shadow: 0 8px 22px rgba(15, 23, 42, .22);
        font-size: 17px;
        line-height: 1;
        transition: .25s ease;
    }

    .tour-img > a.heart {
        position: absolute;
        top: 13px;
        right: 13px;
        z-index: 20;
    }

    .heart:hover {
        color: #e11d48;
        transform: scale(1.08);
    }

    .heart.active {
        color: #fff;
        background: #e11d48;
    }

    .heart.active:hover {
        color: #fff;
        background: #be123c;
    }

    .heart.is-loading {
        pointer-events: none;
        opacity: .68;
    }

    .heart.is-loading i {
        animation: favoritePulse .7s ease infinite alternate;
    }

    .heart i {
        pointer-events: none;
    }

    @keyframes favoritePulse {
        from {
            transform: scale(.84);
        }

        to {
            transform: scale(1.12);
        }
    }

    .tour-card-clickable a,
    .tour-card-clickable button,
    .tour-card-clickable form {
        position: relative;
        z-index: 3;
    }

    /* TOUR BODY */

    .tour-body {
        min-width: 0;
        flex: 1;
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
    }

    .tour-body h3 {
        min-height: 2.7em;
        margin-bottom: 8px;
        overflow: hidden;
        font-size: 18px;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .rating {
        min-height: 20px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
        color: #475569;
        font-size: 13px;
    }

    .rating i {
        color: #f59e0b;
    }

    .rating span {
        color: #64748b;
    }

    .tour-meta {
        min-height: 38px;
        margin-bottom: 12px;
        display: flex;
        align-content: flex-start;
        flex-wrap: wrap;
        gap: 8px 12px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.45;
    }

    .tour-meta i {
        margin-right: 3px;
        color: #0757d8;
    }

    .tour-bottom {
        margin-top: auto;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }

    /* PRICE */

    .home-tour-price {
        min-width: 0;
        min-height: 38px;
        display: flex;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 6px 9px;
    }

    .home-tour-price-old {
        color: #64748b;
        font-size: 14px;
        line-height: 1.2;
        font-weight: 800;
        white-space: nowrap;
        text-decoration-line: line-through;
        text-decoration-color: #475569;
        text-decoration-thickness: 2px;
    }

    .home-tour-price-current {
        color: #0757d8 !important;
        font-size: 21px !important;
        line-height: 1.1 !important;
        font-weight: 900 !important;
        letter-spacing: -.35px;
        white-space: nowrap;
    }

    /* TOUR ACTIONS */

    .tour-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
    }

    .tour-actions a {
        min-width: 92px;
        height: 40px;
        padding: 0 14px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 900;
        white-space: nowrap;
        text-align: center;
        transition: .25s ease;
    }

    .detail-btn {
        border: 1.5px solid #0757d8;
        color: #0757d8;
        background: #fff;
    }

    .detail-btn:hover {
        color: #0757d8;
        background: #eff6ff;
    }

    .book-now-btn {
        border: 1.5px solid #0757d8;
        color: #fff;
        background: #0757d8;
    }

    .book-now-btn:hover {
        color: #fff;
        background: #0044c7;
    }

    /* =========================================================
       DESTINATIONS
    ========================================================= */

    .destination-grid {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 18px;
    }

    .destination-card {
        height: 90px;
        position: relative;
        display: block;
        overflow: hidden;
        border-radius: 14px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
    }

    .destination-card img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .35s ease;
    }

    .destination-card:hover img {
        transform: scale(1.08);
    }

    .destination-card::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            90deg,
            rgba(0, 0, 0, .58),
            rgba(0, 0, 0, .08)
        );
    }

    .destination-card h3 {
        position: absolute;
        left: 16px;
        right: 10px;
        bottom: 14px;
        z-index: 2;
        overflow: hidden;
        color: #fff;
        font-size: 17px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* =========================================================
       PROMOTION
    ========================================================= */

    .promo-section {
        margin-top: 45px;
        padding: 28px;
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr 1fr;
        gap: 22px;
        align-items: center;
        background: #eef7ff;
        border-radius: 20px;
    }

    .promo-title {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .promo-title > i {
        width: 58px;
        height: 58px;
        flex: 0 0 58px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        color: #0757d8;
        background: #dbeafe;
        font-size: 28px;
    }

    .promo-title h3 {
        margin-bottom: 5px;
        font-size: 24px;
    }

    .promo-title p {
        color: #64748b;
        line-height: 1.55;
    }

    .coupon,
    .countdown {
        min-width: 0;
        padding: 18px;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
    }

    .coupon span {
        color: #64748b;
        font-size: 13px;
        font-weight: 800;
    }

    .coupon h3 {
        margin: 4px 0;
        color: #0757d8;
        font-size: 28px;
    }

    .coupon p {
        color: #475569;
        font-size: 14px;
    }

    .coupon button,
    .coupon a {
        margin-left: 8px;
        padding: 8px 12px;
        border: 0;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #fff;
        background: #0757d8;
        font-size: 13px;
        font-weight: 800;
    }

    .coupon button:hover,
    .coupon a:hover {
        background: #0044c7;
    }

    .countdown h4 {
        margin-bottom: 8px;
        color: #334155;
    }

    .countdown .time {
        color: #0757d8;
        font-size: 24px;
        font-weight: 900;
    }

    /* =========================================================
       WHY CHOOSE US
    ========================================================= */

    .why-section {
        margin-top: 70px;
        padding: 80px 0;
        background: #fff;
        text-align: center;
    }

    .big-title {
        margin-bottom: 48px;
        text-align: center;
        font-size: clamp(32px, 3vw, 42px);
        font-weight: 900;
    }

    .why-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 28px;
    }

    .why-card {
        padding: 36px 24px;
        background: #fff;
        border: 1px solid #eef2f7;
        border-radius: 18px;
        box-shadow: 0 16px 38px rgba(15, 23, 42, .08);
        transition:
            transform .3s ease,
            box-shadow .3s ease;
    }

    .why-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 48px rgba(15, 23, 42, .12);
    }

    .why-card i {
        margin-bottom: 16px;
        color: #06b6d4;
        font-size: 28px;
    }

    .why-card h3 {
        margin-bottom: 12px;
        color: #06b6d4;
    }

    .why-card p {
        color: #64748b;
        line-height: 1.65;
    }

    /* =========================================================
       CUSTOMER REVIEWS
    ========================================================= */

    .home-reviews {
        position: relative;
        padding: 90px 0 100px;
        overflow: hidden;
        background:
            radial-gradient(
                circle at 5% 10%,
                rgba(7, 87, 216, .08),
                transparent 28%
            ),
            radial-gradient(
                circle at 95% 90%,
                rgba(56, 189, 248, .10),
                transparent 26%
            ),
            linear-gradient(
                180deg,
                #f8fbff 0%,
                #eef7ff 100%
            );
    }

    .home-reviews::before {
        content: "";
        position: absolute;
        width: 360px;
        height: 360px;
        top: -180px;
        right: -140px;
        border-radius: 50%;
        background: rgba(7, 87, 216, .05);
    }

    .home-reviews .home-container {
        position: relative;
        z-index: 2;
    }

    .home-review-header {
        margin-bottom: 42px;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        align-items: end;
        gap: 40px;
    }

    .home-review-heading {
        max-width: 720px;
    }

    .home-review-eyebrow {
        margin-bottom: 12px;
        padding: 7px 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #0757d8;
        background: #eaf3ff;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .7px;
        text-transform: uppercase;
    }

    .home-review-eyebrow i {
        color: #f59e0b;
    }

    .home-review-heading h2 {
        margin: 0;
        color: #0f172a;
        font-size: clamp(32px, 3.2vw, 48px);
        line-height: 1.15;
        font-weight: 900;
        letter-spacing: -1px;
    }

    .home-review-heading p {
        max-width: 640px;
        margin: 15px 0 0;
        color: #64748b;
        font-size: 16px;
        line-height: 1.75;
    }

    /* REVIEW SUMMARY */

    .home-review-summary {
        min-width: 290px;
        padding: 22px 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        background: rgba(255, 255, 255, .92);
        border: 1px solid rgba(191, 219, 254, .9);
        border-radius: 22px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, .09);
        backdrop-filter: blur(10px);
    }

    .home-review-score {
        color: #0757d8;
        font-size: 48px;
        line-height: 1;
        font-weight: 900;
        letter-spacing: -2px;
    }

    .home-review-summary-info {
        min-width: 0;
    }

    .home-review-summary-stars,
    .home-review-stars {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .home-review-summary-stars {
        margin-bottom: 7px;
    }

    .home-review-summary-stars i,
    .home-review-stars i {
        color: #d8e0ea;
        font-size: 15px;
    }

    .home-review-summary-stars i.active,
    .home-review-stars i.active {
        color: #f59e0b;
    }

    .home-review-summary-text {
        color: #64748b;
        font-size: 13px;
        line-height: 1.45;
        font-weight: 700;
    }

    /* REVIEW GRID */

    .home-review-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 26px;
        align-items: stretch;
    }

    .home-review-card {
        position: relative;
        min-width: 0;
        min-height: 310px;
        padding: 28px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: rgba(255, 255, 255, .96);
        border: 1px solid #e3edf8;
        border-radius: 24px;
        box-shadow: 0 18px 50px rgba(15, 23, 42, .08);
        transition:
            transform .3s ease,
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .home-review-card:hover {
        transform: translateY(-7px);
        border-color: #bfdbfe;
        box-shadow: 0 28px 60px rgba(7, 87, 216, .13);
    }

    .home-review-card::after {
        content: "";
        position: absolute;
        width: 100px;
        height: 100px;
        top: -45px;
        right: -35px;
        border-radius: 50%;
        background: rgba(7, 87, 216, .04);
    }

    .home-review-quote-icon {
        position: absolute;
        top: 24px;
        right: 25px;
        z-index: 1;
        color: #dbeafe;
        font-size: 40px;
    }

    .home-review-user {
        position: relative;
        z-index: 2;
        padding-right: 42px;
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .home-review-avatar {
        width: 50px;
        height: 50px;
        flex: 0 0 50px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        color: #fff;
        background: linear-gradient(135deg, #0757d8, #38bdf8);
        box-shadow: 0 8px 20px rgba(7, 87, 216, .20);
        font-size: 17px;
        font-weight: 900;
        text-transform: uppercase;
    }

    .home-review-user-info {
        min-width: 0;
    }

    .home-review-user-info h4 {
        margin: 0 0 5px;
        overflow: hidden;
        color: #0f172a;
        font-size: 16px;
        font-weight: 900;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .home-review-date {
        color: #94a3b8;
        font-size: 12px;
        font-weight: 700;
    }

    .home-review-date i {
        margin-right: 3px;
    }

    .home-review-stars {
        margin-top: 20px;
    }

    .home-review-card h3 {
        margin: 14px 0 8px;
        overflow: hidden;
        color: #0f172a;
        font-size: 18px;
        line-height: 1.4;
        font-weight: 900;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .home-review-content {
        position: relative;
        z-index: 2;
        margin: 0 0 22px;
        overflow: hidden;
        color: #475569;
        font-size: 14px;
        line-height: 1.8;

        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
    }

    .home-review-tour {
        position: relative;
        z-index: 2;
        margin-top: auto;
        padding-top: 18px;
        border-top: 1px solid #edf2f7;
    }

    .home-review-tour a {
        min-width: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        color: #0757d8;
        transition: .2s ease;
    }

    .home-review-tour a:hover {
        color: #0044c7;
    }

    .home-review-tour-info {
        min-width: 0;
        flex: 1;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 800;
    }

    .home-review-tour-info > i {
        flex: 0 0 auto;
    }

    .home-review-tour-name {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .home-review-view-detail {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 900;
        white-space: nowrap;
    }

    .home-review-view-detail i {
        transition: transform .2s ease;
    }

    .home-review-tour a:hover .home-review-view-detail i {
        transform: translateX(4px);
    }

    /* EMPTY REVIEW */

    .home-review-empty {
        padding: 65px 25px;
        text-align: center;
        background: rgba(255, 255, 255, .82);
        border: 1px dashed #bfdbfe;
        border-radius: 24px;
    }

    .home-review-empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        display: grid;
        place-items: center;
        color: #0757d8;
        background: #eff6ff;
        border-radius: 20px;
        font-size: 30px;
    }

    .home-review-empty h3 {
        margin: 0 0 8px;
        font-size: 21px;
        font-weight: 900;
    }

    .home-review-empty p {
        margin: 0;
        color: #64748b;
    }

    /* =========================================================
       TOUR MESSAGE MODAL
    ========================================================= */

    .tour-message-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        padding: 20px;
        align-items: center;
        justify-content: center;
        background: rgba(15, 23, 42, .58);
        backdrop-filter: blur(4px);
    }

    .tour-message-modal.show {
        display: flex;
    }

    .tour-message-dialog {
        width: min(440px, 100%);
        padding: 26px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 30px 80px rgba(15, 23, 42, .28);
    }

    .tour-message-icon {
        width: 54px;
        height: 54px;
        margin-bottom: 16px;
        display: grid;
        place-items: center;
        color: #0757d8;
        background: #eff6ff;
        border-radius: 16px;
        font-size: 24px;
    }

    .tour-message-dialog h3 {
        margin-bottom: 10px;
        font-size: 22px;
        font-weight: 900;
    }

    .tour-message-dialog p {
        margin-bottom: 20px;
        color: #475569;
        line-height: 1.65;
    }

    .tour-message-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .tour-message-actions button {
        padding: 10px 17px;
        border: 0;
        border-radius: 10px;
        cursor: pointer;
        color: #fff;
        background: #0757d8;
        font-weight: 900;
    }

    .tour-message-actions button:hover {
        background: #0044c7;
    }

    /* =========================================================
       FAVORITE TOAST
    ========================================================= */

    .favorite-toast {
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 10050;
        max-width: min(360px, calc(100vw - 32px));
        padding: 13px 16px;
        display: flex;
        align-items: center;
        gap: 9px;
        visibility: hidden;
        opacity: 0;
        color: #fff;
        background: #0757d8;
        border-radius: 12px;
        box-shadow: 0 16px 38px rgba(15, 23, 42, .24);
        font-size: 14px;
        font-weight: 800;
        transform: translateY(12px);
        transition: .22s ease;
    }

    .favorite-toast.show {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    .favorite-toast.error {
        background: #dc2626;
    }

    /* =========================================================
       RESPONSIVE - LARGE TV
    ========================================================= */

    @media (min-width: 1920px) {
        .home-container,
        .hero-content {
            width: min(1840px, calc(100% - 140px));
            max-width: 1840px;
        }

        .tour-grid {
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }

        .destination-grid {
            grid-template-columns: repeat(8, minmax(0, 1fr));
        }
    }

    /* =========================================================
       RESPONSIVE - LAPTOP
    ========================================================= */

    @media (max-width: 1366px) {
        .home-container,
        .hero-content {
            width: calc(100% - 48px);
        }

        .search-box {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .search-btn {
            grid-column: 1 / -1;
        }

        .stats-box {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .stat-item {
            padding: 18px 24px;
            border-right: 0;
        }

        .stat-item:nth-child(odd) {
            border-right: 1px solid #e5e7eb;
        }

        .stat-item:nth-child(-n + 2) {
            border-bottom: 1px solid #e5e7eb;
        }

        .tour-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .destination-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    /* =========================================================
       RESPONSIVE - TABLET
    ========================================================= */

    @media (max-width: 1100px) {
        .home-review-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 960px) {
        .home-hero-static {
            min-height: auto;
            padding: 70px 0 115px;
        }

        .stats-wrap {
            margin-top: -76px;
        }

        .tour-grid,
        .why-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .destination-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .promo-section {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 850px) {
        .home-review-header {
            grid-template-columns: 1fr;
            align-items: start;
            gap: 24px;
        }

        .home-review-summary {
            width: 100%;
            min-width: 0;
        }
    }

    /* =========================================================
       RESPONSIVE - MOBILE
    ========================================================= */

    @media (max-width: 640px) {
        .home-container,
        .hero-content {
            width: calc(100% - 24px);
        }

        .home-hero-static {
            padding: 54px 0 34px;
        }

        .hero-content h1 {
            font-size: 36px;
        }

        .hero-content h2 {
            margin-top: 6px;
            font-size: 29px;
        }

        .hero-content h2 i {
            margin-left: 8px;
            font-size: 24px;
        }

        .hero-content p {
            margin-bottom: 24px;
            font-size: 15px;
        }

        .search-box {
            grid-template-columns: 1fr;
            border-radius: 14px;
        }

        .search-item {
            padding: 16px 18px;
            border-right: 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .search-item:last-of-type {
            border-bottom: 0;
        }

        .search-btn {
            grid-column: auto;
            width: auto;
            height: 54px;
        }

        .stats-wrap {
            margin-top: 20px;
        }

        .stats-box {
            grid-template-columns: 1fr;
            padding: 10px 18px;
        }

        .stat-item,
        .stat-item:nth-child(odd),
        .stat-item:nth-child(-n + 2) {
            padding: 18px 4px;
            border-right: 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .stat-item:last-child {
            border-bottom: 0;
        }

        .home-section {
            padding-top: 48px;
        }

        .section-head {
            align-items: flex-start;
            gap: 12px;
        }

        .section-head h2 {
            font-size: 25px;
        }

        .tour-grid,
        .destination-grid,
        .why-grid,
        .promo-section,
        .home-review-grid {
            grid-template-columns: 1fr;
        }

        .destination-card {
            height: 105px;
        }

        .tour-body h3,
        .tour-meta {
            min-height: 0;
        }

        .tour-bottom {
            align-items: stretch;
            flex-direction: column;
        }

        .tour-actions {
            width: 100%;
        }

        .tour-actions a {
            flex: 1;
            min-width: 0;
        }

        .promo-section {
            padding: 20px;
        }

        .why-section {
            margin-top: 50px;
            padding: 58px 0;
        }

        .big-title {
            margin-bottom: 30px;
            font-size: 30px;
        }

        .home-reviews {
            padding: 58px 0 65px;
        }

        .home-review-heading h2 {
            font-size: 30px;
        }

        .home-review-heading p {
            font-size: 14px;
        }

        .home-review-summary {
            padding: 18px;
            border-radius: 18px;
        }

        .home-review-score {
            font-size: 42px;
        }

        .home-review-grid {
            gap: 18px;
        }

        .home-review-card {
            min-height: 0;
            padding: 23px;
            border-radius: 20px;
        }

        .home-review-tour a {
            gap: 10px;
        }

        .home-review-view-detail {
            font-size: 11px;
        }

        .favorite-toast {
            left: 16px;
            right: 16px;
            bottom: 16px;
            max-width: none;
        }
    }

    @media (max-width: 430px) {
        .home-review-tour a {
            align-items: flex-start;
            flex-direction: column;
        }

        .home-review-view-detail {
            align-self: flex-end;
            font-size: 12px;
        }
    }

    @media (max-width: 390px) {
        .home-tour-price-old {
            font-size: 13px;
        }

        .home-tour-price-current {
            font-size: 20px !important;
        }

        .section-head {
            flex-direction: column;
        }
    }
</style>


<main>
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    {{-- =========================================================
         HERO
    ========================================================= --}}
    <section class="home-hero-static">

        <div class="hero-static-image">
            <img
                src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=88"
                alt="Du lịch biển cùng Travelloula"
            >
        </div>

        <div class="hero-content">

            <div class="hero-copy">
                <h1>Khám phá thế giới</h1>

                <h2>
                    Cùng Travelloula
                    <i class="fa-solid fa-plane"></i>
                </h2>

                <p>
                    Những hành trình tuyệt vời đang chờ bạn trải nghiệm!
                </p>
            </div>

            <form
                action="{{ route('Client.danh_sach_tour.index') }}"
                method="GET"
                class="search-box"
            >

                <div class="search-item">
                    <i class="fa-solid fa-location-dot"></i>

                    <div>
                        <label>Điểm đến</label>

                        <input
                            type="text"
                            name="keyword"
                            placeholder="Bạn muốn đi đâu?"
                        >
                    </div>
                </div>

                <div class="search-item">
                    <i class="fa-regular fa-calendar-days"></i>

                    <div>
                        <label>Ngày đi</label>

                        <input
                            type="date"
                            name="ngay_khoi_hanh"
                        >
                    </div>
                </div>

                <div class="search-item">
                    <i class="fa-solid fa-car"></i>

                    <div>
                        <label>Phương tiện</label>

                        <input
                            type="text"
                            name="phuong_tien"
                            placeholder="Ô tô..."
                        >
                    </div>
                </div>

                <div class="search-item">
                    <i class="fa-regular fa-user"></i>

                    <div>
                        <label>Số người</label>

                        <input
                            type="number"
                            name="so_nguoi"
                            min="1"
                            value="1"
                        >
                    </div>
                </div>

                <button type="submit" class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Tìm kiếm
                </button>

            </form>

        </div>

    </section>


    {{-- =========================================================
         STATS
    ========================================================= --}}
    <section class="stats-wrap">

        <div class="home-container">

            <div class="stats-box">

                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-suitcase-rolling"></i>
                    </div>

                    <div>
                        <h3>
                            {{ number_format(
                                $totalTours ?? $tours->count(),
                                0,
                                ',',
                                '.'
                            ) }}
                        </h3>

                        <p>Tour</p>
                    </div>
                </div>


                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <div>
                        <h3>
                            {{ number_format(
                                $totalDiemDen ?? $diemDens->count(),
                                0,
                                ',',
                                '.'
                            ) }}
                        </h3>

                        <p>Điểm đến</p>
                    </div>
                </div>


                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div>
                        <h3>
                            {{ number_format(
                                $totalKhachHang ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}
                        </h3>

                        <p>Khách hàng đã trải nghiệm</p>
                    </div>
                </div>


                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <div>
                        <h3>
                            {{ number_format($avgRating, 1) }}/5
                        </h3>

                        <p>Đánh giá trung bình</p>
                    </div>
                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         TOUR NỔI BẬT
    ========================================================= --}}
    <section class="home-section">

        <div class="home-container">

            <div class="section-head">

                <h2>Tour</h2>

                <a href="{{ route('Client.danh_sach_tour.index') }}">
                    Xem tất cả
                    <i class="fa-solid fa-angle-right"></i>
                </a>

            </div>


            @if(session('success'))

                <div
                    style="
                        margin-bottom:18px;
                        padding:14px 16px;
                        border-radius:12px;
                        background:#ecfdf5;
                        border:1px solid #bbf7d0;
                        color:#047857;
                        font-weight:800;
                    "
                >
                    <i class="fa-solid fa-circle-check"></i>

                    {{ session('success') }}
                </div>

            @endif


            <div class="tour-grid">

                @forelse($tours as $tour)

                    @php

                        $fallbackTourImage =
                            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';

                        $tourImage = $fallbackTourImage;

                        if (!empty($tour->anh_dai_dien)) {

                            if (
                                \Illuminate\Support\Str::startsWith(
                                    $tour->anh_dai_dien,
                                    ['http://', 'https://']
                                )
                            ) {
                                $tourImage = $tour->anh_dai_dien;
                            } else {
                                $tourImage = asset($tour->anh_dai_dien);
                            }
                        }


                        $isFavorite = auth()->check()
                            ? in_array(
                                (int) $tour->id,
                                $favoriteTourIds,
                                true
                            )
                            : false;


                        $tourReviewStat =
                            $reviewStatsByTour->get($tour->id);

                        $tourAverageRating =
                            (float) (
                                $tourReviewStat->diem_trung_binh ?? 0
                            );

                        $tourReviewCount =
                            (int) (
                                $tourReviewStat->tong_danh_gia ?? 0
                            );


                        /*
                         * Lịch khởi hành
                         */
                        $lichKhoiHanhs =
                            collect($tour->lichKhoiHanhTours ?? [])
                                ->filter(function ($lich) {

                                    return in_array(
                                        $lich->trang_thai,
                                        [
                                            'available',
                                            'running',
                                            'full',
                                            'closed',
                                        ],
                                        true
                                    );
                                })
                                ->sortBy('ngay_khoi_hanh')
                                ->values();


                        $lichGanNhat =
                            $lichKhoiHanhs
                                ->firstWhere(
                                    'trang_thai',
                                    'available'
                                )
                            ?? $lichKhoiHanhs->first();


                        $coLichMoBan =
                            $lichKhoiHanhs->contains(
                                function ($lich) {

                                    return
                                        $lich->trang_thai === 'available'
                                        &&
                                        (int) $lich->so_cho_con_lai > 0;
                                }
                            );


                        $lyDoKhongDat =
                            'Tour hiện chưa có lịch khởi hành có thể đặt.';


                        if ($lichKhoiHanhs->isEmpty()) {

                            $lyDoKhongDat =
                                'Tour hiện chưa có lịch khởi hành.';

                        } elseif (
                            $lichKhoiHanhs->every(
                                fn ($lich) =>
                                    $lich->trang_thai === 'closed'
                            )
                        ) {

                            $lyDoKhongDat =
                                'Tất cả lịch khởi hành của tour đã đóng.';

                        } elseif (
                            $lichKhoiHanhs->every(
                                fn ($lich) =>
                                    $lich->trang_thai === 'full'
                            )
                        ) {

                            $lyDoKhongDat =
                                'Tất cả lịch khởi hành của tour đã hết chỗ.';

                        } elseif (
                            $lichKhoiHanhs->contains(
                                fn ($lich) =>
                                    $lich->trang_thai === 'running'
                            )
                        ) {

                            $lyDoKhongDat =
                                'Tour đang diễn ra nên không thể nhận thêm khách ở lịch này.';

                        } elseif (!$coLichMoBan) {

                            $lyDoKhongDat =
                                'Hiện chưa có lịch mở bán và còn chỗ.';
                        }


                        /*
                         * Giá tour
                         */
                        $giaNiemYetTrangChu =
                            (int) round(
                                (float) (
                                    ((float) ($tour->gia_nguoi_lon ?? 0) > 0)
                                        ? $tour->gia_nguoi_lon
                                        : ($tour->gia_tour ?? 0)
                                )
                            );


                        $giaHienThiTrangChu =
                            $giaNiemYetTrangChu;

                        $coGiaCaoDiemTrangChu = false;


                        if (
                            $lichGanNhat
                            &&
                            !empty($lichGanNhat->ngay_khoi_hanh)
                        ) {

                            $ngayKhoiHanhTinhGia =
                                \Carbon\Carbon::parse(
                                    $lichGanNhat->ngay_khoi_hanh
                                )->startOfDay();


                            $bangGiaApDungTrangChu =
                                collect($tour->bangGiaTours ?? [])
                                    ->filter(
                                        function ($bangGia)
                                        use ($ngayKhoiHanhTinhGia) {

                                            if (
                                                ($bangGia->trang_thai ?? null)
                                                    !== 'active'
                                                ||
                                                empty($bangGia->ngay_bat_dau)
                                                ||
                                                empty($bangGia->ngay_ket_thuc)
                                            ) {
                                                return false;
                                            }


                                            $ngayBatDau =
                                                \Carbon\Carbon::parse(
                                                    $bangGia->ngay_bat_dau
                                                )->startOfDay();


                                            $ngayKetThuc =
                                                \Carbon\Carbon::parse(
                                                    $bangGia->ngay_ket_thuc
                                                )->endOfDay();


                                            return
                                                $ngayKhoiHanhTinhGia
                                                    ->gte($ngayBatDau)
                                                &&
                                                $ngayKhoiHanhTinhGia
                                                    ->lte($ngayKetThuc);
                                        }
                                    )
                                    ->sortByDesc(
                                        function ($bangGia) {

                                            return sprintf(
                                                '%s-%020d',
                                                (string) $bangGia->ngay_bat_dau,
                                                (int) $bangGia->id
                                            );
                                        }
                                    )
                                    ->first();


                            if ($bangGiaApDungTrangChu) {

                                $phanTramTangTrangChu =
                                    max(
                                        0,
                                        (float) (
                                            $bangGiaApDungTrangChu
                                                ->phan_tram_tang
                                            ?? 0
                                        )
                                    );


                                if ($phanTramTangTrangChu > 0) {

                                    $giaHienThiTrangChu =
                                        (int) round(
                                            $giaNiemYetTrangChu
                                            *
                                            (
                                                1
                                                +
                                                (
                                                    $phanTramTangTrangChu
                                                    / 100
                                                )
                                            )
                                        );


                                    $coGiaCaoDiemTrangChu = true;
                                }
                            }
                        }


                        /*
                         * Nếu Controller đã tính sẵn giá
                         * thì ưu tiên dữ liệu Controller.
                         */
                        if (isset($tour->gia_niem_yet)) {
                            $giaNiemYetTrangChu =
                                (int) $tour->gia_niem_yet;
                        }

                        if (isset($tour->gia_hien_thi)) {
                            $giaHienThiTrangChu =
                                (int) $tour->gia_hien_thi;
                        }

                        if (isset($tour->co_gia_cao_diem)) {
                            $coGiaCaoDiemTrangChu =
                                (bool) $tour->co_gia_cao_diem;
                        }

                    @endphp


                    <article
                        class="tour-card tour-card-clickable"
                        role="link"
                        tabindex="0"
                        data-detail-url="{{ route(
                            'Client.danh_sach_tour.show',
                            $tour->id
                        ) }}"
                        aria-label="Xem chi tiết tour {{ $tour->ten_tour }}"
                    >

                        <div class="tour-img">

                            <img
                                src="{{ $tourImage }}"
                                alt="{{ $tour->ten_tour }}"
                                onerror="this.onerror=null;this.src='{{ $fallbackTourImage }}';"
                            >


                            <span class="discount">
                                {{ $tour->danhMuc->ten_danh_muc
                                    ?? 'Tour nổi bật' }}
                            </span>


                            @auth

                                <form
                                    action="{{ $isFavorite
                                        ? route(
                                            'Client.tour_yeu_thich.destroy',
                                            $tour->id
                                        )
                                        : route(
                                            'Client.tour_yeu_thich.store',
                                            $tour->id
                                        )
                                    }}"
                                    method="POST"
                                    class="
                                        home-favorite-form
                                        js-home-favorite-form
                                    "
                                    data-store-url="{{ route(
                                        'Client.tour_yeu_thich.store',
                                        $tour->id
                                    ) }}"
                                    data-destroy-url="{{ route(
                                        'Client.tour_yeu_thich.destroy',
                                        $tour->id
                                    ) }}"
                                    data-favorite="{{ $isFavorite ? '1' : '0' }}"
                                >

                                    @csrf

                                    @if($isFavorite)

                                        <input
                                            type="hidden"
                                            name="_method"
                                            value="DELETE"
                                            class="favorite-method-input"
                                        >

                                    @endif


                                    <button
                                        class="heart {{ $isFavorite ? 'active' : '' }}"
                                        type="submit"
                                        title="{{ $isFavorite
                                            ? 'Bỏ yêu thích'
                                            : 'Thêm vào yêu thích'
                                        }}"
                                        aria-label="{{ $isFavorite
                                            ? 'Bỏ yêu thích'
                                            : 'Thêm vào yêu thích'
                                        }}"
                                        aria-pressed="{{ $isFavorite
                                            ? 'true'
                                            : 'false'
                                        }}"
                                    >
                                        <i
                                            class="{{ $isFavorite
                                                ? 'fa-solid'
                                                : 'fa-regular'
                                            }} fa-heart"
                                        ></i>
                                    </button>

                                </form>

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="heart"
                                    title="Đăng nhập để thêm yêu thích"
                                    aria-label="Đăng nhập để thêm yêu thích"
                                >
                                    <i class="fa-regular fa-heart"></i>
                                </a>

                            @endauth

                        </div>


                        <div class="tour-body">

                            <h3>
                                {{ $tour->ten_tour }}
                            </h3>


                            <p class="rating">

                                <i class="fa-solid fa-star"></i>

                                @if($tourReviewCount > 0)

                                    {{ number_format(
                                        $tourAverageRating,
                                        1
                                    ) }}/5

                                    <span>
                                        ({{ $tourReviewCount }} đánh giá)
                                    </span>

                                @else

                                    <span>Chưa có đánh giá</span>

                                @endif

                            </p>


                            <div class="tour-meta">

                                <span>
                                    <i class="fa-regular fa-clock"></i>

                                    {{ $tour->thoi_luong
                                        ?? 'Đang cập nhật' }}
                                </span>

                                <span>
                                    <i class="fa-solid fa-location-dot"></i>

                                    {{ $tour->diem_den
                                        ?? 'Đang cập nhật' }}
                                </span>

                                <span>
                                    <i class="fa-solid fa-users"></i>

                                    {{ $tour->so_khach_toi_da ?? 0 }}
                                    chỗ
                                </span>

                            </div>


                            <div class="tour-bottom">

                                <div class="home-tour-price">

                                    @if($coGiaCaoDiemTrangChu)

                                        <span class="home-tour-price-old">

                                            {{ number_format(
                                                $giaNiemYetTrangChu,
                                                0,
                                                ',',
                                                '.'
                                            ) }}đ

                                        </span>


                                        <strong class="home-tour-price-current">

                                            {{ number_format(
                                                $giaHienThiTrangChu,
                                                0,
                                                ',',
                                                '.'
                                            ) }}đ

                                        </strong>

                                    @else

                                        <strong class="home-tour-price-current">

                                            {{ number_format(
                                                $giaHienThiTrangChu,
                                                0,
                                                ',',
                                                '.'
                                            ) }}đ

                                        </strong>

                                    @endif

                                </div>


                                <div class="tour-actions">

                                    <a
                                        href="{{ route(
                                            'Client.danh_sach_tour.show',
                                            $tour->id
                                        ) }}"
                                        class="detail-btn"
                                    >
                                        Xem chi tiết
                                    </a>


                                    <a
                                        href="{{ route(
                                            'Client.danh_sach_tour.show',
                                            $tour->id
                                        ) }}#dat-tour"
                                        class="book-now-btn{{ $coLichMoBan
                                            ? ''
                                            : ' js-tour-message'
                                        }}"
                                        @unless($coLichMoBan)
                                            data-message="{{ $lyDoKhongDat }}"
                                            data-block-booking="1"
                                        @endunless
                                    >
                                        Đặt tour
                                    </a>

                                </div>

                            </div>

                        </div>

                    </article>

                @empty

                    <p>Chưa có tour nào được hiển thị.</p>

                @endforelse

            </div>

        </div>

    </section>


    {{-- =========================================================
         ĐIỂM ĐẾN + KHUYẾN MÃI
    ========================================================= --}}
    <section class="home-section">

        <div class="home-container">

            <div class="section-head">

                <h2>Điểm đến</h2>

                <a href="{{ route('Client.danh_sach_tour.index') }}">
                    Xem tất cả
                    <i class="fa-solid fa-angle-right"></i>
                </a>

            </div>


            <div class="destination-grid">

                @forelse($diemDens as $item)

                    @php

                        $fallbackDestinationImage =
                            'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';

                        $destinationImage =
                            $fallbackDestinationImage;


                        if (!empty($item->anh_dai_dien)) {

                            if (
                                \Illuminate\Support\Str::startsWith(
                                    $item->anh_dai_dien,
                                    ['http://', 'https://']
                                )
                            ) {
                                $destinationImage =
                                    $item->anh_dai_dien;
                            } else {
                                $destinationImage =
                                    asset($item->anh_dai_dien);
                            }
                        }

                    @endphp


                    <a
                        href="{{ route(
                            'Client.danh_sach_tour.index',
                            ['keyword' => $item->diem_den]
                        ) }}"
                        class="destination-card"
                    >

                        <img
                            src="{{ $destinationImage }}"
                            alt="{{ $item->diem_den }}"
                            onerror="this.onerror=null;this.src='{{ $fallbackDestinationImage }}';"
                        >

                        <h3>
                            {{ $item->diem_den }}
                        </h3>

                    </a>

                @empty

                    <p>Chưa có điểm đến nổi bật.</p>

                @endforelse

            </div>


            <div class="promo-section">

                <div class="promo-title">

                    <i class="fa-solid fa-gift"></i>

                    <div>

                        <h3>Ưu đãi hấp dẫn</h3>

                        <p>
                            @if(
                                isset($khuyenMais)
                                &&
                                $khuyenMais->count()
                            )

                                {{ $khuyenMais->count() }}
                                chương trình khuyến mãi đang áp dụng.

                            @else

                                Ưu đãi sẽ được cập nhật
                                trong thời gian tới.

                            @endif
                        </p>

                    </div>

                </div>


                @forelse(
                    ($khuyenMais ?? collect())->take(2)
                    as $km
                )

                    <div class="coupon">

                        <span>
                            {{ $km->ten_khuyen_mai
                                ?? $km->mo_ta
                                ?? 'KHUYẾN MÃI' }}
                        </span>


                        <h3>

                            @php

                                $phanTramGiam =
                                    $km->phan_tram_giam ?? null;

                                $soTienGiam =
                                    $km->so_tien_giam ?? null;

                            @endphp


                            @if(!empty($phanTramGiam))

                                {{ number_format(
                                    $phanTramGiam,
                                    0,
                                    ',',
                                    '.'
                                ) }}%

                            @elseif(!empty($soTienGiam))

                                {{ number_format(
                                    $soTienGiam,
                                    0,
                                    ',',
                                    '.'
                                ) }}đ

                            @else

                                Ưu đãi

                            @endif

                        </h3>


                        <p>

                            Mã:

                            <b class="coupon-code">
                                {{ $km->ma_khuyen_mai
                                    ?? 'ĐANG CẬP NHẬT' }}
                            </b>

                            <button
                                type="button"
                                class="js-copy-coupon"
                                data-code="{{ $km->ma_khuyen_mai ?? '' }}"
                            >
                                Sao chép
                            </button>

                        </p>

                    </div>

                @empty

                    <div class="coupon">

                        <span>TOUR GIÁ TỐT</span>

                        <h3>
                            {{ number_format(
                                ($tours->min('gia_tour') ?? 0),
                                0,
                                ',',
                                '.'
                            ) }}đ
                        </h3>

                        <p>
                            Tour giá tốt nhất hiện có

                            <a href="{{ route(
                                'Client.danh_sach_tour.index'
                            ) }}">
                                Xem ngay
                            </a>
                        </p>

                    </div>


                    <div class="coupon">

                        <span>TOUR MỚI</span>

                        <h3>
                            {{ $tours->count() }}+
                        </h3>

                        <p>
                            Tour đang mở bán

                            <a href="{{ route(
                                'Client.danh_sach_tour.index'
                            ) }}">
                                Khám phá
                            </a>
                        </p>

                    </div>

                @endforelse


                <div class="countdown">

                    <h4>Tour đang mở bán</h4>

                    <div class="time">
                        {{ $tours->count() }} tour
                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         WHY CHOOSE US
    ========================================================= --}}
    <section class="why-section">

        <div class="home-container">

            <h2 class="big-title">
                Vì Sao Chọn Travelloula?
            </h2>


            <div class="why-grid">

                <div class="why-card">

                    <i class="fa-solid fa-plane"></i>

                    <h3>Tour Chất Lượng</h3>

                    <p>
                        Lịch trình hấp dẫn và dịch vụ chuyên nghiệp.
                    </p>

                </div>


                <div class="why-card">

                    <i class="fa-solid fa-sack-dollar"></i>

                    <h3>Giá Tốt</h3>

                    <p>
                        Chi phí hợp lý cùng nhiều ưu đãi hấp dẫn.
                    </p>

                </div>


                <div class="why-card">

                    <i class="fa-solid fa-shield-heart"></i>

                    <h3>An Toàn</h3>

                    <p>
                        Đội ngũ hướng dẫn viên giàu kinh nghiệm.
                    </p>

                </div>


                <div class="why-card">

                    <i class="fa-solid fa-phone"></i>

                    <h3>Hỗ Trợ 24/7</h3>

                    <p>
                        Luôn sẵn sàng hỗ trợ khách hàng mọi lúc.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
         CUSTOMER REVIEWS
    ========================================================= --}}
    <section class="home-reviews">

        <div class="home-container">

            <div class="home-review-header">

                <div class="home-review-heading">

                    <div class="home-review-eyebrow">

                        <i class="fa-solid fa-star"></i>

                        Trải nghiệm thực tế

                    </div>


                    <h2>
                        Khách hàng nói gì về Travelloula?
                    </h2>


                    <p>
                        Những chia sẻ chân thực từ khách hàng sau mỗi
                        hành trình là động lực để Travelloula ngày càng
                        hoàn thiện và mang đến những chuyến đi tốt hơn.
                    </p>

                </div>


                <div class="home-review-summary">

                    <div class="home-review-score">
                        {{ number_format($avgRating, 1) }}
                    </div>


                    <div class="home-review-summary-info">

                        <div class="home-review-summary-stars">

                            @for($star = 1; $star <= 5; $star++)

                                <i
                                    class="fa-solid fa-star
                                    {{ $star <= round($avgRating)
                                        ? 'active'
                                        : ''
                                    }}"
                                ></i>

                            @endfor

                        </div>


                        <div class="home-review-summary-text">

                            {{ number_format(
                                $totalReviews,
                                0,
                                ',',
                                '.'
                            ) }}
                            đánh giá từ khách hàng

                        </div>

                    </div>

                </div>

            </div>


            @if($homeReviews->count())

                <div class="home-review-grid">

                    @foreach($homeReviews->take(6) as $review)

                        <article class="home-review-card">

                            <i
                                class="
                                    fa-solid
                                    fa-quote-right
                                    home-review-quote-icon
                                "
                            ></i>


                            <div class="home-review-user">

                                <div class="home-review-avatar">

                                    {{ mb_strtoupper(
                                        mb_substr(
                                            trim(
                                                $review->ho_ten
                                                ?? 'K'
                                            ),
                                            0,
                                            1
                                        )
                                    ) }}

                                </div>


                                <div class="home-review-user-info">

                                    <h4>
                                        {{ $review->ho_ten
                                            ?? 'Khách hàng' }}
                                    </h4>


                                    @if(
                                        !empty(
                                            $review->thoi_gian_danh_gia
                                        )
                                    )

                                        <div class="home-review-date">

                                            <i
                                                class="
                                                    fa-regular
                                                    fa-calendar
                                                "
                                            ></i>

                                            {{ \Carbon\Carbon::parse(
                                                $review
                                                    ->thoi_gian_danh_gia
                                            )->format('d/m/Y') }}

                                        </div>

                                    @endif

                                </div>

                            </div>


                            <div class="home-review-stars">

                                @for(
                                    $star = 1;
                                    $star <= 5;
                                    $star++
                                )

                                    <i
                                        class="fa-solid fa-star
                                        {{ $star <=
                                            (int) $review->so_sao
                                            ? 'active'
                                            : ''
                                        }}"
                                    ></i>

                                @endfor

                            </div>


                            @if(!empty($review->tieu_de))

                                <h3>
                                    {{ $review->tieu_de }}
                                </h3>

                            @endif


                            <p class="home-review-content">

                                “{{ $review->noi_dung_danh_gia
                                    ?? 'Khách hàng đã có một trải nghiệm tuyệt vời cùng Travelloula.'
                                }}”

                            </p>


                            @if(
                                !empty($review->ten_tour)
                                &&
                                !empty($review->tour_id)
                            )

                                <div class="home-review-tour">

                                    <a
                                        href="{{ route(
                                            'Client.danh_sach_tour.show',
                                            $review->tour_id
                                        ) }}#danh-gia"
                                    >

                                        <span class="home-review-tour-info">
                                            <i class="fa-solid fa-location-dot"></i>

                                            <span class="home-review-tour-name">
                                                {{ $review->ten_tour }}
                                            </span>
                                        </span>

                                        <strong class="home-review-view-detail">
                                            Xem đánh giá
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </strong>

                                    </a>

                                </div>

                            @endif

                        </article>

                    @endforeach

                </div>

            @else

                <div class="home-review-empty">

                    <div class="home-review-empty-icon">

                        <i
                            class="
                                fa-regular
                                fa-comment-dots
                            "
                        ></i>

                    </div>


                    <h3>
                        Chưa có đánh giá từ khách hàng
                    </h3>


                    <p>
                        Những cảm nhận đầu tiên sau chuyến đi
                        sẽ sớm xuất hiện tại đây.
                    </p>

                </div>

            @endif

        </div>

    </section>


    {{-- =========================================================
         BOOKING MESSAGE MODAL
    ========================================================= --}}
    <div
        class="tour-message-modal"
        id="tourMessageModal"
        aria-hidden="true"
    >

        <div
            class="tour-message-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="tourMessageTitle"
        >

            <div class="tour-message-icon">
                <i class="fa-solid fa-circle-info"></i>
            </div>


            <h3 id="tourMessageTitle">
                Chưa thể đặt tour
            </h3>


            <p id="tourMessageText">
                Tour hiện chưa thể đặt.
            </p>


            <div class="tour-message-actions">

                <button
                    type="button"
                    id="closeTourMessageModal"
                >
                    Đã hiểu
                </button>

            </div>

        </div>

    </div>


    {{-- =========================================================
         FAVORITE TOAST
    ========================================================= --}}
    <div
        class="favorite-toast"
        id="favoriteToast"
        role="status"
        aria-live="polite"
    >

        <i class="fa-solid fa-circle-check"></i>

        <span id="favoriteToastText">
            Đã cập nhật tour yêu thích.
        </span>

    </div>

</main>


{{-- =============================================================
     SCRIPT - TOUR MESSAGE
============================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const modal =
            document.getElementById('tourMessageModal');

        const messageText =
            document.getElementById('tourMessageText');

        const closeButton =
            document.getElementById('closeTourMessageModal');


        if (!modal || !messageText || !closeButton) {
            return;
        }


        document
            .querySelectorAll('.js-tour-message')
            .forEach(function (button) {

                button.addEventListener(
                    'click',
                    function (event) {

                        if (
                            button.dataset.blockBooking === '1'
                        ) {
                            event.preventDefault();

                            messageText.textContent =
                                button.dataset.message
                                ||
                                'Tour hiện chưa thể đặt.';

                            modal.classList.add('show');

                            modal.setAttribute(
                                'aria-hidden',
                                'false'
                            );
                        }
                    }
                );

            });


        function closeModal() {

            modal.classList.remove('show');

            modal.setAttribute(
                'aria-hidden',
                'true'
            );
        }


        closeButton.addEventListener(
            'click',
            closeModal
        );


        modal.addEventListener(
            'click',
            function (event) {

                if (event.target === modal) {
                    closeModal();
                }
            }
        );


        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {
                    closeModal();
                }
            }
        );

    });
</script>


{{-- =============================================================
     SCRIPT - CLICK TOÀN BỘ TOUR CARD
============================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document
            .querySelectorAll('.tour-card-clickable')
            .forEach(function (card) {

                const detailUrl =
                    card.dataset.detailUrl;


                function goToDetail() {

                    if (detailUrl) {
                        window.location.href =
                            detailUrl;
                    }
                }


                card.addEventListener(
                    'click',
                    function (event) {

                        if (
                            event.target.closest(
                                'a, button, form, input, select, textarea, label'
                            )
                        ) {
                            return;
                        }

                        goToDetail();
                    }
                );


                card.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key !== 'Enter'
                            &&
                            event.key !== ' '
                        ) {
                            return;
                        }


                        if (
                            event.target.closest(
                                'a, button, form, input, select, textarea, label'
                            )
                        ) {
                            return;
                        }


                        event.preventDefault();

                        goToDetail();
                    }
                );

            });

    });
</script>


{{-- =============================================================
     SCRIPT - FAVORITE AJAX
============================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const toast =
            document.getElementById('favoriteToast');

        const toastText =
            document.getElementById('favoriteToastText');

        let toastTimer = null;


        function showFavoriteToast(
            message,
            isError = false
        ) {

            if (!toast || !toastText) {
                return;
            }


            toastText.textContent = message;

            toast.classList.toggle(
                'error',
                isError
            );


            const toastIcon =
                toast.querySelector('i');


            if (toastIcon) {

                toastIcon.className =
                    isError
                        ? 'fa-solid fa-circle-exclamation'
                        : 'fa-solid fa-circle-check';
            }


            toast.classList.add('show');


            window.clearTimeout(toastTimer);


            toastTimer =
                window.setTimeout(
                    function () {

                        toast.classList.remove('show');

                    },
                    2200
                );
        }


        document
            .querySelectorAll(
                '.js-home-favorite-form'
            )
            .forEach(function (form) {

                form.addEventListener(
                    'submit',
                    async function (event) {

                        event.preventDefault();

                        event.stopPropagation();


                        const button =
                            form.querySelector('.heart');

                        const icon =
                            button?.querySelector('i');


                        if (
                            !button
                            ||
                            !icon
                            ||
                            button.classList.contains(
                                'is-loading'
                            )
                        ) {
                            return;
                        }


                        const isFavorite =
                            form.dataset.favorite === '1';


                        button.classList.add(
                            'is-loading'
                        );

                        button.disabled = true;


                        try {

                            const formData =
                                new FormData(form);


                            const response =
                                await fetch(
                                    form.action,
                                    {
                                        method: 'POST',

                                        body: formData,

                                        credentials:
                                            'same-origin',

                                        headers: {
                                            'X-Requested-With':
                                                'XMLHttpRequest',

                                            'Accept':
                                                'application/json, text/html'
                                        }
                                    }
                                );


                            if (!response.ok) {

                                throw new Error(
                                    'Không thể cập nhật tour yêu thích.'
                                );
                            }


                            const nextFavoriteState =
                                !isFavorite;


                            form.dataset.favorite =
                                nextFavoriteState
                                    ? '1'
                                    : '0';


                            form.action =
                                nextFavoriteState
                                    ? form.dataset.destroyUrl
                                    : form.dataset.storeUrl;


                            let methodInput =
                                form.querySelector(
                                    '.favorite-method-input'
                                );


                            if (nextFavoriteState) {

                                if (!methodInput) {

                                    methodInput =
                                        document.createElement(
                                            'input'
                                        );


                                    methodInput.type =
                                        'hidden';

                                    methodInput.name =
                                        '_method';

                                    methodInput.value =
                                        'DELETE';

                                    methodInput.className =
                                        'favorite-method-input';


                                    form.appendChild(
                                        methodInput
                                    );
                                }

                            } else {

                                methodInput?.remove();
                            }


                            button.classList.toggle(
                                'active',
                                nextFavoriteState
                            );


                            button.setAttribute(
                                'aria-pressed',
                                nextFavoriteState
                                    ? 'true'
                                    : 'false'
                            );


                            button.title =
                                nextFavoriteState
                                    ? 'Bỏ yêu thích'
                                    : 'Thêm vào yêu thích';


                            button.setAttribute(
                                'aria-label',
                                nextFavoriteState
                                    ? 'Bỏ yêu thích'
                                    : 'Thêm vào yêu thích'
                            );


                            icon.classList.toggle(
                                'fa-solid',
                                nextFavoriteState
                            );


                            icon.classList.toggle(
                                'fa-regular',
                                !nextFavoriteState
                            );


                            showFavoriteToast(
                                nextFavoriteState
                                    ? 'Đã lưu tour vào danh sách yêu thích.'
                                    : 'Đã xóa tour khỏi danh sách yêu thích.'
                            );


                        } catch (error) {

                            showFavoriteToast(
                                'Cập nhật yêu thích thất bại. Hãy tải lại trang rồi thử lại.',
                                true
                            );

                        } finally {

                            button.classList.remove(
                                'is-loading'
                            );

                            button.disabled = false;
                        }
                    }
                );

            });

    });
</script>


{{-- =============================================================
     SCRIPT - COPY COUPON
============================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document
            .querySelectorAll('.js-copy-coupon')
            .forEach(function (button) {

                button.addEventListener(
                    'click',
                    async function () {

                        const code =
                            button.dataset.code;


                        if (!code) {
                            return;
                        }


                        try {

                            await navigator.clipboard
                                .writeText(code);


                            const oldText =
                                button.textContent;


                            button.textContent =
                                'Đã chép';


                            setTimeout(
                                function () {
                                    button.textContent =
                                        oldText;
                                },
                                1500
                            );

                        } catch (error) {

                            console.error(
                                'Không thể sao chép mã khuyến mãi.',
                                error
                            );
                        }
                    }
                );

            });

    });
</script>

@endsection