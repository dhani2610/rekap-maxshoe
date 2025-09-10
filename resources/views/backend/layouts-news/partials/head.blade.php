  <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Rekap Order Maxshoe</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css" />
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logos/6646489.png') }}" />

      <style>
          body {
              background: #f9fafc;
              font-family: "Poppins", sans-serif;
          }

          .sidebar {
              width: 200px;
              background: #fff;
              min-height: 100vh;
              box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
              position: fixed;
          }

          .sidebar a {
              padding: 12px;
              color: #333;
              display: block;
              text-decoration: none;
          }

          .sidebar a.active {
              background: #0a53be;
              color: white;
          }

          main {
              margin-left: 200px;
              padding: 20px;
          }

          .section-header {
              background: linear-gradient(90deg, #1e3c72, #2a5298);
              color: white;
              padding: 8px 16px;
              height: 45px;
              border-radius: 8px;
              display: flex;
              align-items: center;
              box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
          }

          .btn-custom {
              background: linear-gradient(90deg, #14532d, #166534);
              color: white;
              border: none;
              border-radius: 8px;
              padding: 10px 50px;
              font-weight: 600;
              font-size: 14px;
              transition: transform 0.2s ease, background 0.3s ease;
          }

          .btn-custom:hover {
              background: linear-gradient(90deg, #166534, #14532d);
              transform: scale(1.05);
              color: white;
          }

          .page-title {
              font-size: 26px;
              font-weight: 700;
              color: #1e3c72;
              text-transform: uppercase;
              letter-spacing: 1px;
              display: flex;
              align-items: center;
              gap: 12px;
              position: relative;
              overflow: hidden;
          }

          .page-title::before {
              content: "";
              width: 8px;
              height: 32px;
              background: linear-gradient(180deg, #1e3c72, #2a5298);
              border-radius: 4px;
          }

          .page-title::after {
              content: "";
              position: absolute;
              top: 0;
              left: -75%;
              width: 50%;
              height: 100%;
              background: linear-gradient(120deg,
                      rgba(255, 255, 255, 0) 0%,
                      rgba(255, 255, 255, 0.4) 50%,
                      rgba(255, 255, 255, 0) 100%);
              transform: skewX(-20deg);
              animation: shine 2s infinite;
          }

          @keyframes shine {
              0% {
                  left: -75%;
              }

              100% {
                  left: 125%;
              }
          }

          .table th {
              background: linear-gradient(to bottom, #1e3c72, #2a5297);
              color: white;
              font-weight: 600;
              font-size: 13px;
              padding-top: 10px;
              padding-bottom: 10px;
              text-transform: uppercase;
              letter-spacing: 0.5px;
              border: 1px solid #ccc;
          }

          .table td {
              font-size: 13px;
              padding-top: 4px;
              padding-bottom: 4px;
          }

          .badge-status {
              padding: 2px 4px;
              font-size: 10px;
              border-radius: 2px;
              display: inline-block;
              color: white;
          }

          .badge-status.lunas {
              background: linear-gradient(90deg, #22c55e, #16a34a);
          }

          .badge-status.dp {
              background: linear-gradient(90deg, #facc15, #eab308);
              color: #333;
          }

          .badge-status.po {
              background: linear-gradient(90deg, #3b82f6, #1d4ed8);
          }

          .badge-status.cod {
              background: linear-gradient(90deg, #f43f5e, #b91c1c);
              color: #fff;
          }

          .btn-inputdata {
              background: linear-gradient(90deg, #1e3c72, #2a5298);
              color: white;
              border: none;
              padding: 8px 20px;
              font-weight: 600;
              border-radius: 8px;
              display: flex;
              align-items: center;
              gap: 6px;
              box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
              transition: 0.3s ease;
          }

          .btn-inputdata:hover {
              background: linear-gradient(90deg, #2a5298, #1e3c72);
              color: white;
          }
      </style>
  </head>
