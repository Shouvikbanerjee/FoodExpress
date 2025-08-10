<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>FoodExpress Loading</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      color: #6b4bb5eb;
      user-select: none;
      text-align: center;
      padding: 1rem;
    }

    /* Loader container animation */
    .loader-container {
      text-align: center;
      opacity: 0;
      transform: translateY(30px);
      animation: fadeSlideUp 1s ease forwards;
    }
    @keyframes fadeSlideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .logo {
      font-size: clamp(1.5rem, 2.5vw, 2.5rem);
      font-weight: 700;
      letter-spacing: 0.15em;
      margin-bottom: 1rem;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
      flex-wrap: wrap;
    }
    .logo img {
      width: clamp(24px, 5vw, 40px);
      height: auto;
    }

    /* Food icons */
    .food-icons {
      display: flex;
      gap: clamp(0.5rem, 2vw, 1rem);
      justify-content: center;
      font-size: clamp(1.5rem, 5vw, 2.5rem);
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
    }
    @keyframes rotate {
      0%   { transform: rotate(0deg); }
      50%  { transform: rotate(360deg); }
      100% { transform: rotate(0deg); }
    }
    .food-icons span {
      display: inline-block;
      animation: rotate 2s linear infinite;
      transform-origin: 50% 50%;
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }
    .food-icons span:nth-child(1) { animation-delay: 0s; }
    .food-icons span:nth-child(2) { animation-delay: 0.33s; }
    .food-icons span:nth-child(3) { animation-delay: 0.66s; }
    .food-icons span:nth-child(4) { animation-delay: 0.99s; }
    .food-icons span:nth-child(5) { animation-delay: 1.32s; }
    .food-icons span:nth-child(6) { animation-delay: 1.65s; }
    .food-icons span:hover {
      opacity: 1;
      animation-play-state: paused;
    }

    /* Loading dots */
    .loading-dots {
      font-size: clamp(0.9rem, 1.5vw, 1rem);
      color: #190e2fa1;
      font-weight: 600;
      letter-spacing: 0.1em;
      font-family: monospace;
    }
    @keyframes blink {
      0%, 20% { opacity: 0; }
      40% { opacity: 1; }
      60%, 100% { opacity: 0; }
    }
    .loading-dots span {
      opacity: 0;
      animation: blink 1.5s infinite;
      display: inline-block;
      margin-left: 2px;
    }
    .loading-dots span:nth-child(1) { animation-delay: 0s; }
    .loading-dots span:nth-child(2) { animation-delay: 0.3s; }
    .loading-dots span:nth-child(3) { animation-delay: 0.6s; }

    /* Extra small screen adjustments */
    @media (max-width: 480px) {
      .logo {
        letter-spacing: 0.05em;
      }
      .food-icons {
        gap: 0.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="loader-container" role="alert" aria-live="polite">
    <div class="logo">
      <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" alt="logo" />
      FoodExpress
    </div>

    <div class="food-icons" aria-hidden="true">
      <span title="Pizza 🍕">🍕</span>
      <span title="Burger 🍔">🍔</span>
      <span title="Fries 🍟">🍟</span>
      <span title="Sushi 🍣">🍣</span>
      <span title="Taco 🌮">🌮</span>
      <span title="Soft Drink 🥤">🥤</span>
    </div>

    <div class="loading-dots" aria-hidden="true">
      Loading
      <span>.</span><span>.</span><span>.</span>
    </div>
  </div>

  <script>
    setTimeout(() => {
      window.location.href = "home.php";
    }, 8000);
  </script>
</body>
</html>
