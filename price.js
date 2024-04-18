

function calculateDistance(latA, lonA, latB, lonB) {
    const R = 6371; // Радиус Земли в километрах

    const phiA = latA * Math.PI / 180;
    const phiB = latB * Math.PI / 180;
    const lambdaA = lonA * Math.PI / 180;
    const lambdaB = lonB * Math.PI / 180;

    const d = Math.acos(Math.sin(phiA) * Math.sin(phiB) + Math.cos(phiA) * Math.cos(phiB) * Math.cos(lambdaA - lambdaB));
    const L = d * R;

    return L;
}

// Пример использования функции
const distance = calculateDistance(55.7558, 37.6176, 59.9343, 30.3351);
console.log(distance); 