var map = new google.maps.Map(document.getElementById("map"), {
  center: { lat: 40.143105, lng: 47.576927 },
  zoom: 7,
  minZoom: 7,
  styles: [
    {
        "featureType": "all",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "weight": "2.00"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "color": "#9c9c9c"
            }
        ]
    },
    {
        "featureType": "all",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#eeeeee"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#7b7b7b"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#46bcec"
            },
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "color": "#c8d7d4"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#070707"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "color": "#ffffff"
            }
        ]
    }
]
});

// Create an array of marker objects
/*var markers = [
  new google.maps.Marker({
    id: 1,
    position: { lat: 40.565247, lng: 49.697788 },
    title: "Sumqayıt şəhəri, 10-cu mikrorayon, Babək küçəsi 208.",
    map: map,
    description: "11i Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 2,
    position: { lat: 39.789238, lng: 46.754616 },
    title: "Şuşa şəhəri",
    map: map,
    description: "7s Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 3,
    position: { lat: 41.327469, lng: 48.148575 },
    title:
      "Qusar rayonu, Qusar-Laza yolunun 29-cu km-də yerləşən Şahdağ Turizm Mərkəzinin ərazisi",
    map: map,
    description: "6s Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 4,
    position: { lat: 40.481506, lng: 49.836922 },
    title:
      "Bakı şəhəri, Binəqədi rayonu, Binəqədi qəsəbəsinin şimal hissəsi, Binəqədi – Novxanı yolu.",
    map: map,
    description: "20 Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 5,
    position: { lat: 38.7358312, lng: 48.6478097 },
    title: "Lerik rayonu, Piran kəndi, 20-ci km.",
    map: map,
    description: "7s Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 6,
    position: { lat: 39.6448135, lng: 49.0096903 },
    title: "Salyan rayonu, Salyan şəhəri, Ələt-Astara yolu, 19-cu km.",
    map: map,
    description: "7s Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 7,
    position: { lat: 40.4334679, lng: 49.7839394 },
    title:
      "Bakı şəhəri, Biləcəri qəsəbəsi, Sumqayıt şosesi, 2-ci km. 4 ünvanında, Dövlət Yol Polis İdarəsinə məxsus ekologiya postu yaxınlığında",
    map: map,
    description: "7s Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 8,
    position: { lat: 40.645077, lng: 46.861198 },
    title:
      "Gürcüstan-Qazax-Bakı magistralının üzərində - Goranboy rayonunun Boluslu kəndi ərazisi",
    map: map,
    description: "7s Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 9,
    position: { lat: 40.845223, lng: 47.219486 },
    title:
      "Yevlax-Zaqatala yolu istiqaməti, Şəki şəhərinin sonuncu kəndi sayılan Çayqaraqoyunlu kəndi ərazisi",
    map: map,
    description: "7s Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 10,
    position: { lat: 40.566123, lng: 49.856742 },
    title: "Binəqədi rayonu, Goradil qəsəbəsi",
    map: map,
    description: "7s Saylı YDM",
    category: "Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),

  new google.maps.Marker({
    id: 11,
    position: { lat: 40.35494995665633, lng: 49.98022083786964 },
    title: "Zığ Hövsan yolu",
    map: map,
    description: "7s Saylı YDM",
    category: "CNG",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 12,
    position: { lat: 40.362507676381995, lng: 49.79659167571003 },
    title: "Yasamal Rayonu, Qanlı Göl yaxınlığında",
    map: map,
    description: "7s Saylı YDM",
    category: "Market, CNG",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 13,
    position: { lat: 40.45839217737267, lng: 50.33639524598868 },
    title: "Pirallahi qəsəbəsi",
    map: map,
    description: "7s Saylı YDM",
    category: "Avtoservis, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 14,
    position: { lat: 40.44167366898836, lng: 47.90471711719874 },
    title: "Ucar rayonu, Müsüslü kəndi",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 15,
    position: { lat: 40.64506315341404, lng: 46.86577158048749 },
    title: "Goranboy rayonu, Cinli Boluslu kəndi",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, Market, Ultra High speed Diesel Dispenser",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 16,
    position: { lat: 40.37615473821027, lng: 49.91473902744474 },
    title: "Xətai rayonu, Nobel prospekti",
    map: map,
    description: "7s Saylı YDM",
    category: "Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 17,
    position: { lat: 40.59588545549406, lng: 48.697361110243946 },
    title: "Şamaxı rayonu, Sabir qəsəbəsi",
    map: map,
    description: "7s Saylı YDM",
    category: "",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 18,
    position: { lat: 40.656964353975965, lng: 48.64114978350699 },
    title: "Şamaxı rayonu, Əngəxaran kəndi",
    map: map,
    description: "7s Saylı YDM",
    category: "Avtoservis, Market, Kontaktsız avtoyuma",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 19,
    position: { lat: 40.04261200055342, lng: 49.06045155599713 },
    title: "Hacıqabul rayonu, Pirsaat qəsəbəsi",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 20,
    position: { lat: 40.42539474231832, lng: 49.90617351606488 },
    title: "Z.Bünyadov pr-ti  +994125652885",
    map: map,
    description: "7s Saylı YDM",
    category: "Market, CNG",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),

  new google.maps.Marker({
    id: 21,
    position: { lat: 40.9702533, lng: 49.2445387 },
    title: "Siyəzən rayonu, Bakı-Quba yolunun 86-cı kilometrliyi, sol tərəf",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Market, Ultra High speed Diesel Dispenser",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 22,
    position: { lat: 40.97082, lng: 49.2453 },
    title: "Siyəzən rayonu, Bakı-Quba yolunun 86-cı kilometrliyi, sağ tərəf",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Market, Ultra High speed Diesel Dispenser",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 23,
    position: { lat: 40.39247, lng: 49.91479 },
    title:
      "Bakı şəhəri, Babək pr-ti ilə O.Vəliyev küçəsinin kəsişməsi Tel:570-08-02 ",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 24,
    position: { lat: 40.39353, lng: 49.93257 },
    title:
      "Bakı şəhəri, Xətai rayonu, Babək pr-ti 2315-ci məhəllə(Maşın bazarının yaxınlığı) Tel:570-06-12",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Market, CNG",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 25,
    position: { lat: 40.43522, lng: 49.93094 },
    title:
      "Bakı şəhəri, Sabunçu rayonu, Sabunçu ŞTQ, Sabunçu dairəsinin cənub qərb hissəsi. H.Əliyev pr-ti 333 Tel:565-17-51",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Market, CNG",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 26,
    position: { lat: 40.5562953, lng: 49.638338 },
    title:
      "Bakı Quba yolunun 28-ci km-də, yolun sag tərəfində, Ceyranbatan qəsəbəsi yaxınlığında  Tel:555-11-52",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 27,
    position: { lat: 40.5564, lng: 49.63995 },
    title:
      "Bakı Quba yolunun 28-ci km-də, yolun sol tərəfində, Ceyranbatan qəsəbəsi yaxınlığında  Tel:555-11-52",
    map: map,
    description: "7s Saylı YDM",
    category: "LPG, Avtoservis, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 28,
    position: { lat: 40.2959, lng: 49.75288 },
    title:
      "Bakı Salyan şossesinin 14-cü km-i, Lökbatan qəsəbəsi yaxınlığında, yolun sağ tərəfində  Tel:565-13-56",
    map: map,
    description: "7s Saylı YDM",
    category:
      "Kafe, LPG, Avtoservis, Market, Motel, Ultra High speed Diesel Dispenser",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 29,
    position: { lat: 39.970193, lng: 49.4165262 },
    title:
      "Bakı Salyan şossesinin 70-ci km-i, Haciqabul-Astara yol ayrıcı, yolun sol tərəfində Tel:544-26-73",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Avtoservis, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 30,
    position: { lat: 39.9675712, lng: 49.4103489 },
    title:
      "Bakı Salyan şossesinin 70-ci km-i, Haciqabul-Astara yol ayrıcı, yolun sağ tərəfində Tel:544-26-86",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Avtoservis, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),

  new google.maps.Marker({
    id: 31,
    position: { lat: 40.31858, lng: 49.82177 },
    title:
      "Bakı şəhəri, Səbail rayonu , Yeni Salyan yolu, 25 km, Bina 31 (Bibiheybət məscidinden şəhər istiqamətində yeni çəkilmiş yolun sağ tərəfində) Tel:555-50-82",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Avtoservis, Market, Kontaktsız avtoyuma",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 32,
    position: { lat: 40.35525, lng: 49.95408 },
    title: "Zığ şosessi, Gənclik parkı yanında.",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 33,
    position: { lat: 40.4327, lng: 50.05867 },
    title: "Aeroport-Bakı yeni salınmış beton yolun sağ tərəfində",
    map: map,
    description: "7s Saylı YDM",
    category: "LPG",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 34,
    position: { lat: 40.46438, lng: 49.94401 },
    title:
      "Bakı şəhəri, Sabunçu rayonu, Bakı-Zabrat yolu sağ tərəf Tel:555-50-83",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Market, CNG",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 35,
    position: { lat: 40.4718, lng: 50.10465 },
    title:
      "Xəzər rayonu, Mərdəkan Ş.T.Q, Mərdəkan-Qala yol ayrıcının cənub-qərb hissəsi Tel:555-50-81",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 36,
    position: { lat: 40.51693, lng: 50.06012 },
    title:
      "Bakı şəhəri, Xəzər rayonu, Buzovna qəsəbəsi, Maştağa yolu Albalılıq, Abşeron küçəsi 105 Tel:555-15-97",
    map: map,
    description: "7s Saylı YDM",
    category: "Market",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 37,
    position: { lat: 40.439114723888636, lng: 49.93923978880048 },
    title:
      "Bakı-Aeroport yolunun sağ tərəfində, Sabunçu dairəsi yaxınlığında Tel:450-04-52",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG, Ev Charger, Avtoservis, Market, Kontaktsız avtoyuma",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 38,
    position: { lat: 40.4303981, lng: 50.1911831 },
    title: "Abşeron rayonu, 3 saylı zeytun sovxozunun ərazisi. Tel:555-15-96",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
  new google.maps.Marker({
    id: 39,
    position: { lat: 40.44076659325543, lng: 50.01330681145191 },
    title:
      "Bakı ş-ri, Suraxanı r-nu, Yeni Suraxanı Qəsəbəsi, Bakı-Aeroport yolu, 7-ci km, 1 Tel:458-92-43",
    map: map,
    description: "7s Saylı YDM",
    category: "Kafe, LPG,  Ev Charger, Avtoservis",
    icon: {
      url: "data:image/svg+xml;charset=UTF-8,<svg xmlns='http://www.w3.org/2000/svg' width='74' height='119' viewBox='0 0 74 119'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='%23FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='%236EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='%2333ADE1'/></svg>",
      scaledSize: new google.maps.Size(40, 40),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(20, 40),
    },
  }),
]; */

let markerCluster = new MarkerClusterer(map, markers, {
  gridSize: 50,
  maxZoom: 15,
  zoomOnClick: true,
  minimumClusterSize: 2,
  imagePath:
    "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
  styles: [
    {
      textColor: "white",
      textSize: 16,
      url: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m1.png",
      height: 53,
      width: 53,
    },
    {
      textColor: "white",
      textSize: 16,
      url: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m2.png",
      height: 56,
      width: 56,
    },
  ],
});

let activeMarkers = markers;

let backSidebar = document.getElementById("back-icon");

google.maps.event.addListener(map, "zoom_changed", function () {
  var zoomLevel = map.getZoom();
  if (zoomLevel < 10) {
    groupMarkers(activeMarkers);
  } 
  // else {
  //   addAllSidebarContent(activeMarkers);
  // }
});

function groupMarkers(groupMarkers) {
  // Remove all existing markers from the markerCluster object
  markerCluster.clearMarkers();

  // Add the updated markers to the markerCluster object
  markerCluster.addMarkers(groupMarkers);
}

let sidebar = document.getElementById("sidebar");
function addAllSidebarContent(actMarkers) {
  let sidebarContent = "";
  sidebarContent = actMarkers
    .map(
      (marker) => `
  <div id="${marker.id}" class="content" style="cursor:pointer">
                  <p class="go-location"
                    >${marker.getTitle()}</p
                  >
                  <p>${marker.description}</p>
                  <p>${marker.category}</p>
                  <hr>
  </div>
`
    )
    .join("");
  sidebar.innerHTML = sidebarContent;
  backSidebar.style.display = "none";
}
addAllSidebarContent(markers);
var selectedMarker = null;

var svgIcon = {
  url:
    "data:image/svg+xml;charset=UTF-8," +
    encodeURIComponent(
      "<svg width='74' height='119' viewBox='0 0 74 119' fill='none' xmlns='http://www.w3.org/2000/svg'><path d='M29.85 17.53C29.85 48.95 3.53003 54.83 3.53003 85.03C3.53003 96.82 10.96 107.03 19.73 108.25C19.09 106.1 18.88 104.44 18.88 102.12C18.88 80.32 53.92 73.56 53.92 36.38C53.92 18.6 41.38 3.57 26.75 0C26.75 0 29.84 9.65 29.84 17.52L29.85 17.53Z' fill='#FF2F2B'/><path d='M27.6299 103.44C27.6299 109.61 31.9999 116.18 37.6999 118.32C37.3999 117.41 37.2599 116.61 37.2599 115.27C37.2599 103.12 73.1999 99.2499 73.1999 67.4999C73.1999 58.7199 69.5299 49.1899 62.2599 42.9399C57.3399 79.0299 27.6299 83.9999 27.6299 103.44Z' fill='#6EC248'/><path d='M8.8 10.08C8.8 10.08 10.53 13.19 10.53 16.66C10.53 27.81 0 32.06 0 43.39C0 48.74 2.91 53.13 7.02 55.68C7.13 54.71 7.23 53.8 7.48 53.04C9.94 45.17 21.48 36.46 21.48 24.11C21.48 16.71 15.34 10.62 8.8 10.08Z' fill='#33ADE1'/></svg>"
    ),
  scaledSize: new google.maps.Size(50, 50),
  origin: new google.maps.Point(0, 0),
  anchor: new google.maps.Point(25, 50),
};
function clickSideBarItems() {
  // add event listeners to sidebar items
  document.querySelectorAll(".content").forEach((el) => {
    el.addEventListener("click", () => {
      // Reset the icon of the previously selected marker
      if (selectedMarker !== null) {
        selectedMarker.setIcon(svgIcon);
      }
      const markerId = el.id;
      const marker = markers.find((m) => parseInt(m.id) === parseInt(markerId));
      // Set the selected marker to the clicked marker

      map.panTo(marker.getPosition());
      map.setZoom(15);
      marker.setAnimation(google.maps.Animation.BOUNCE);
      marker.setIcon(svgIcon);
      setTimeout(() => {
        marker.setAnimation(null);
      }, 1500);
      selectedMarker = marker;
      let sidebarContent = "";
      sidebarContent = `
  <div id="${marker.id}" class="content" style="cursor:pointer">
                  <p class="go-location"
                    >${marker.getTitle()}</p
                  >
                  <p>${marker.description}</p>
                  <p>${marker.category}</p>
                  <hr>


  </div>
`;
      sidebar.innerHTML = sidebarContent;
      backSidebar.style.display = "block";
    });
  });
}
clickSideBarItems();

backSidebar.addEventListener("click", function back() {
  addAllSidebarContent(activeMarkers);
  clickSideBarItems();
  map.setZoom(7);
  map.panTo({ lat: 40.143105, lng: 47.576927 });

  // Clear the current marker cluster
  markerCluster.clearMarkers();

  // Recreate the marker cluster with the filtered markers
  markerCluster = new MarkerClusterer(map, activeMarkers, {
    imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
    styles: [
      {
        textColor: "white",
        textSize: 16,
        url: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m1.png",
        height: 53,
        width: 53,
      },
      {
        textColor: "white",
        textSize: 16,
        url: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m2.png",
        height: 56,
        width: 56,
      },
    ],
  });
  
});

activeMarkers.forEach(function (marker) {
  marker.addListener("click", function () {
    if (selectedMarker !== null) {
      selectedMarker.setIcon(svgIcon);
    }
    map.panTo(marker.getPosition());
    map.setZoom(15);
    marker.setAnimation(google.maps.Animation.BOUNCE);
    marker.setIcon(svgIcon);
    setTimeout(() => {
      marker.setAnimation(null);
    }, 1500);

    selectedMarker = marker;

    let sidebarContent = "";
    sidebarContent += `
  <div id="${marker.id}" class="content" style="cursor:pointer">
                  <p class="go-location"
                    >${marker.getTitle()}</p
                  >
                  <p>${marker.description}</p>
                  <p>${marker.category}</p>
                  <hr>

  </div>
`;
    sidebar.innerHTML = sidebarContent;
    backSidebar.style.display = "block";
  });
});

window.onclick = function (event) {
  if (!event.target.matches(".dropbtn-map")) {
    var dropdowns = document.getElementsByClassName("dropdown-content-map");
    for (var i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.style.display === "block") {
        openDropdown.style.display = "none";
      }
    }
  }
};

var select = document.getElementById("my-select");
select.addEventListener("change", function () {
  var selectedCategory = this.value;
  console.log(selectedCategory);
  markers.forEach(function (marker) {
    console.log(marker.category);
    if (
      selectedCategory === "all" ||
      marker.category
        .toLowerCase()
        .trim()
        .includes(selectedCategory.toLowerCase())
    ) {
      marker.setMap(map);
    } else {
      marker.setMap(null);
    }
  });

  activeMarkers = markers.filter(function (marker) {
    return marker.map !== null && marker.map !== undefined;
  });
  groupMarkers(activeMarkers);
  addAllSidebarContent(activeMarkers);
  clickSideBarItems();
});
