// Обработчик для видео
document.getElementById('playButton')?.addEventListener('click', function () {
    const imgElement = document.getElementById('mediaElement');
    const parentDiv = imgElement.parentElement;

    // Сохраняем все вычисленные стили изображения
    const imgStyles = window.getComputedStyle(imgElement);

    // Создаем iframe
    const iframe = document.createElement('iframe');
    iframe.src = 'https://vk.com/video_ext.php?oid=-197461611&id=456246610&hash=de659849ea1930ca&autoplay=1';
    iframe.style.width = imgStyles.width;
    iframe.style.height = imgStyles.height;
    iframe.style.maxWidth = imgStyles.maxWidth;
    iframe.style.maxHeight = imgStyles.maxHeight;
    iframe.style.objectFit = 'cover';
    iframe.style.borderRadius = '25px';
    iframe.style.border = 'none';
    iframe.allowFullscreen = true;
    iframe.className = 'img-fluid';

    // Создаем обертку для iframe
    const wrapper = document.createElement('div');
    wrapper.className = 'img-fluid';
    wrapper.style.position = 'relative';
    wrapper.style.width = '100%';
    wrapper.style.height = '100%';
    wrapper.appendChild(iframe);

    // Заменяем изображение на обертку с iframe
    imgElement.replaceWith(wrapper);

    // Скрываем кнопку
    this.style.display = 'none';
});

// Инициализация слайдера
document.addEventListener('DOMContentLoaded', function () {
    const sliderTrack = document.querySelector('.row.flex-nowrap');
    const slides = document.querySelectorAll('.col-sm-10.col-md-10.col-lg-4.col-xl-4.col-xxl-3');
    const prevBtn = document.querySelector('.btn-group > button:first-child');
    const nextBtn = document.querySelector('.btn-group > button:last-child');

    if (!sliderTrack || !slides.length || !prevBtn || !nextBtn) return;

    const sliderContainer = sliderTrack.parentElement;
    let currentPosition = 0;
    let slideWidth, containerWidth, maxPosition;

    function initSlider() {
        // Получаем актуальные размеры
        slideWidth = slides[0].offsetWidth + parseInt(window.getComputedStyle(slides[0]).marginRight);
        containerWidth = sliderContainer.offsetWidth;

        // Рассчитываем максимальную позицию
        const totalWidth = slideWidth * slides.length;
        maxPosition = Math.max(0, totalWidth - containerWidth);

        updateSlider();
    }

    function updateSlider() {
        // Ограничиваем текущую позицию
        currentPosition = Math.max(0, Math.min(currentPosition, maxPosition));

        // Применяем трансформацию
        sliderTrack.style.transform = `translateX(-${currentPosition}px)`;

        // Обновляем состояние кнопок
        prevBtn.style.opacity = currentPosition <= 0 ? '0.36' : '1';
        nextBtn.style.opacity = currentPosition >= maxPosition ? '0.36' : '1';
    }

    nextBtn.addEventListener('click', function () {
        if (currentPosition < maxPosition) {
            currentPosition += slideWidth;
            if (currentPosition > maxPosition) {
                currentPosition = maxPosition;
            }
            updateSlider();
        }
    });

    prevBtn.addEventListener('click', function () {
        if (currentPosition > 0) {
            currentPosition -= slideWidth;
            if (currentPosition < 0) {
                currentPosition = 0;
            }
            updateSlider();
        }
    });

    // Оптимизация обработки resize
    let resizeTimeout;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(initSlider, 100);
    });

    // Инициализация при загрузке
    initSlider();

    // Дополнительная инициализация после полной загрузки всех ресурсов
    window.addEventListener('load', initSlider);
});
