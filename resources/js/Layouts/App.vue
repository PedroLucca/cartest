<template >

  <TopBar>
    <div class="bg-white w-full fixed px-2 shadow-sm top-0 z-20">
      <div class="lg:ml-60 p-3 flex items-center transition-all duration-300" :class="{'lg:ml-20': toggleMenu}">
        <button @click="toggleMenu = !toggleMenu" class="max-lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
        </button>
        <button @click="toggleMenuMobile = !toggleMenuMobile" class="lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
        </button>
       
        <div class="flex ml-auto items-center">
          <div class="flex flex-col mr-3">
            
            <span class="text-[15px] font-semibold">{{$page.props?.user?.name}}</span>
            <span class="text-[12px] text-gray-500">{{ $page.props?.user?.email }}</span>
          </div>
          <img class="rounded-full h-10 w-10 object-cover" alt="" :src="$page.props.user?.profile_picture" onerror="this.src='/images/profile_default.png';">
        </div>      

        <Link class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px]" href="/logout" method="post">
        <svg version="1.1" fill="currentColor" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 330 330" style="enable-background:new 0 0 330 330;" class="h-5 w-5 ml-5 text-red-500" xml:space="preserve">
          <g id="XMLID_2_">
            <path id="XMLID_4_" d="M51.213,180h173.785c8.284,0,15-6.716,15-15s-6.716-15-15-15H51.213l19.394-19.393
                  c5.858-5.857,5.858-15.355,0-21.213c-5.856-5.858-15.354-5.858-21.213,0L4.397,154.391c-0.348,0.347-0.676,0.71-0.988,1.09
                  c-0.076,0.093-0.141,0.193-0.215,0.288c-0.229,0.291-0.454,0.583-0.66,0.891c-0.06,0.09-0.109,0.185-0.168,0.276
                  c-0.206,0.322-0.408,0.647-0.59,0.986c-0.035,0.067-0.064,0.138-0.099,0.205c-0.189,0.367-0.371,0.739-0.53,1.123
                  c-0.02,0.047-0.034,0.097-0.053,0.145c-0.163,0.404-0.314,0.813-0.442,1.234c-0.017,0.053-0.026,0.108-0.041,0.162
                  c-0.121,0.413-0.232,0.83-0.317,1.257c-0.025,0.127-0.036,0.258-0.059,0.386c-0.062,0.354-0.124,0.708-0.159,1.069
                  C0.025,163.998,0,164.498,0,165s0.025,1.002,0.076,1.498c0.035,0.366,0.099,0.723,0.16,1.08c0.022,0.124,0.033,0.251,0.058,0.374
                  c0.086,0.431,0.196,0.852,0.318,1.269c0.015,0.049,0.024,0.101,0.039,0.15c0.129,0.423,0.28,0.836,0.445,1.244
                  c0.018,0.044,0.031,0.091,0.05,0.135c0.16,0.387,0.343,0.761,0.534,1.13c0.033,0.065,0.061,0.133,0.095,0.198
                  c0.184,0.341,0.387,0.669,0.596,0.994c0.056,0.088,0.104,0.181,0.162,0.267c0.207,0.309,0.434,0.603,0.662,0.895
                  c0.073,0.094,0.138,0.193,0.213,0.285c0.313,0.379,0.641,0.743,0.988,1.09l44.997,44.997C52.322,223.536,56.161,225,60,225
                  s7.678-1.464,10.606-4.394c5.858-5.858,5.858-15.355,0-21.213L51.213,180z" />
            <path id="XMLID_5_" d="M207.299,42.299c-40.944,0-79.038,20.312-101.903,54.333c-4.62,6.875-2.792,16.195,4.083,20.816
                  c6.876,4.62,16.195,2.794,20.817-4.083c17.281-25.715,46.067-41.067,77.003-41.067C258.414,72.299,300,113.884,300,165
                  s-41.586,92.701-92.701,92.701c-30.845,0-59.584-15.283-76.878-40.881c-4.639-6.865-13.961-8.669-20.827-4.032
                  c-6.864,4.638-8.67,13.962-4.032,20.826c22.881,33.868,60.913,54.087,101.737,54.087C274.956,287.701,330,232.658,330,165
                  S274.956,42.299,207.299,42.299z" />
          </g>
        </svg>
        </Link>
      </div>
    </div>
  </TopBar>

  <SideBar >
    <div class="bg-white shadow-md max-lg:hidden lg:w-60 h-full fixed top-0 transition-all duration-300 z-50 overflow-y-auto" :class="{'!w-20': toggleMenu}">
      <div class="flex">
        <svg width="100%" height="58" viewBox="0 0 158 78" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M25.6 63.024C20.992 63.024 16.96 62.192 13.504 60.528C10.048 58.8213 7.36 56.4747 5.44 53.488C3.56267 50.4587 2.624 46.96 2.624 42.992C2.624 39.0667 3.30667 35.4613 4.672 32.176C6.08 28.8907 8.04267 26.0533 10.56 23.664C13.0773 21.2747 16.064 19.44 19.52 18.16C22.976 16.8373 26.7733 16.176 30.912 16.176C35.2213 16.176 39.04 16.944 42.368 18.48C45.696 20.016 48.1707 22.2347 49.792 25.136L38.912 33.648C37.9733 31.984 36.7573 30.704 35.264 29.808C33.7707 28.8693 32 28.4 29.952 28.4C28.16 28.4 26.5173 28.7413 25.024 29.424C23.5733 30.064 22.3147 31.0027 21.248 32.24C20.1813 33.4347 19.3493 34.864 18.752 36.528C18.1547 38.192 17.856 40.0267 17.856 42.032C17.856 43.7813 18.24 45.3173 19.008 46.64C19.776 47.9627 20.8427 48.9867 22.208 49.712C23.616 50.4373 25.2373 50.8 27.072 50.8C28.8213 50.8 30.528 50.3947 32.192 49.584C33.8987 48.7733 35.52 47.4507 37.056 45.616L45.952 54.128C43.2213 57.456 40.1707 59.7813 36.8 61.104C33.472 62.384 29.7387 63.024 25.6 63.024Z" fill="#E36600"/>
<path d="M47.82 49.36C46.524 49.36 45.252 49.012 44.004 48.316C42.756 47.596 41.724 46.564 40.908 45.22C40.116 43.852 39.72 42.196 39.72 40.252C39.72 38.62 39.996 37.12 40.548 35.752C41.1 34.384 41.856 33.196 42.816 32.188C43.8 31.156 44.916 30.364 46.164 29.812C47.436 29.236 48.78 28.948 50.196 28.948C51.732 28.948 53.064 29.26 54.192 29.884C55.32 30.508 56.124 31.564 56.604 33.052C57.108 34.516 57.156 36.544 56.748 39.136C56.412 41.248 55.836 43.072 55.02 44.608C54.228 46.144 53.232 47.32 52.032 48.136C50.832 48.952 49.428 49.36 47.82 49.36ZM50.88 42.952C51.6 42.952 52.224 42.772 52.752 42.412C53.28 42.028 53.688 41.5 53.976 40.828C54.288 40.156 54.444 39.364 54.444 38.452C54.444 37.54 54.18 36.796 53.652 36.22C53.148 35.644 52.44 35.356 51.528 35.356C50.832 35.356 50.208 35.548 49.656 35.932C49.128 36.292 48.708 36.808 48.396 37.48C48.108 38.152 47.964 38.944 47.964 39.856C47.964 40.768 48.216 41.512 48.72 42.088C49.248 42.664 49.968 42.952 50.88 42.952ZM52.788 49L53.328 46.336L54.66 39.136L55.704 32.008L56.244 29.308H64.38L60.456 49H52.788ZM64.027 49L67.951 29.308H75.619L74.503 34.888L73.747 33.304C74.563 31.744 75.691 30.628 77.131 29.956C78.595 29.284 80.263 28.948 82.135 28.948L80.695 36.148C80.359 36.1 80.047 36.064 79.759 36.04C79.495 36.016 79.219 36.004 78.931 36.004C77.587 36.004 76.495 36.304 75.655 36.904C74.839 37.504 74.287 38.5 73.999 39.892L72.163 49H64.027ZM90.4043 49.36C88.7243 49.36 87.2963 49.048 86.1203 48.424C84.9443 47.8 84.1163 46.888 83.6363 45.688C83.1563 44.464 83.0843 43 83.4203 41.296L86.6963 24.88H94.8323L91.5563 41.26C91.4363 41.932 91.5083 42.424 91.7723 42.736C92.0363 43.048 92.4443 43.204 92.9963 43.204C93.3323 43.204 93.6323 43.168 93.8963 43.096C94.1843 43 94.4843 42.88 94.7963 42.736L95.7323 48.208C94.9883 48.616 94.1483 48.904 93.2123 49.072C92.3003 49.264 91.3643 49.36 90.4043 49.36ZM81.6923 36.328L82.8803 30.388H97.7483L96.5603 36.328H81.6923ZM108.74 49.36C106.58 49.36 104.684 48.988 103.052 48.244C101.444 47.5 100.184 46.444 99.2716 45.076C98.3596 43.708 97.9036 42.1 97.9036 40.252C97.9036 38.092 98.4076 36.16 99.4156 34.456C100.424 32.752 101.84 31.408 103.664 30.424C105.512 29.44 107.66 28.948 110.108 28.948C112.22 28.948 114.02 29.32 115.508 30.064C116.996 30.808 118.136 31.828 118.928 33.124C119.72 34.42 120.116 35.92 120.116 37.624C120.116 38.224 120.068 38.812 119.972 39.388C119.9 39.964 119.804 40.516 119.684 41.044H104.384L105.14 37.12H115.94L112.556 38.164C112.748 37.396 112.736 36.748 112.52 36.22C112.328 35.668 111.992 35.248 111.512 34.96C111.032 34.648 110.444 34.492 109.748 34.492C108.764 34.492 107.984 34.756 107.408 35.284C106.832 35.812 106.412 36.496 106.148 37.336C105.908 38.176 105.788 39.052 105.788 39.964C105.788 41.188 106.112 42.064 106.76 42.592C107.432 43.096 108.404 43.348 109.676 43.348C110.42 43.348 111.164 43.24 111.908 43.024C112.652 42.784 113.336 42.436 113.96 41.98L117.344 46.912C116 47.824 114.596 48.46 113.132 48.82C111.692 49.18 110.228 49.36 108.74 49.36ZM128.555 49.36C126.803 49.36 125.135 49.192 123.551 48.856C121.991 48.496 120.779 48.064 119.915 47.56L122.723 42.016C123.707 42.616 124.811 43.072 126.035 43.384C127.283 43.672 128.459 43.816 129.563 43.816C130.475 43.816 131.099 43.732 131.435 43.564C131.795 43.372 131.975 43.144 131.975 42.88C131.975 42.592 131.735 42.388 131.255 42.268C130.775 42.124 130.151 42.004 129.383 41.908C128.639 41.812 127.847 41.668 127.007 41.476C126.167 41.284 125.363 41.008 124.595 40.648C123.851 40.264 123.239 39.736 122.759 39.064C122.279 38.392 122.039 37.504 122.039 36.4C122.039 34.696 122.531 33.304 123.515 32.224C124.523 31.12 125.867 30.304 127.547 29.776C129.227 29.224 131.087 28.948 133.127 28.948C134.567 28.948 135.947 29.08 137.267 29.344C138.611 29.584 139.799 29.944 140.831 30.424L138.023 35.968C136.991 35.368 135.959 34.972 134.927 34.78C133.919 34.588 132.995 34.492 132.155 34.492C131.219 34.492 130.571 34.6 130.211 34.816C129.851 35.008 129.671 35.224 129.671 35.464C129.671 35.752 129.911 35.968 130.391 36.112C130.871 36.256 131.483 36.388 132.227 36.508C132.971 36.604 133.763 36.748 134.603 36.94C135.467 37.108 136.271 37.384 137.015 37.768C137.759 38.128 138.371 38.644 138.851 39.316C139.331 39.988 139.571 40.876 139.571 41.98C139.571 43.612 139.067 44.98 138.059 46.084C137.075 47.188 135.743 48.016 134.063 48.568C132.407 49.096 130.571 49.36 128.555 49.36ZM150.135 49.36C148.455 49.36 147.027 49.048 145.851 48.424C144.675 47.8 143.847 46.888 143.367 45.688C142.887 44.464 142.815 43 143.151 41.296L146.427 24.88H154.563L151.287 41.26C151.167 41.932 151.239 42.424 151.503 42.736C151.767 43.048 152.175 43.204 152.727 43.204C153.063 43.204 153.363 43.168 153.627 43.096C153.915 43 154.215 42.88 154.527 42.736L155.463 48.208C154.719 48.616 153.879 48.904 152.943 49.072C152.031 49.264 151.095 49.36 150.135 49.36ZM141.423 36.328L142.611 30.388H157.479L156.291 36.328H141.423Z" fill="#E36600"/>
</svg>

        <!-- <img class="mx-auto w-100" src="/images/logo_menu.png" alt="" srcset="" > -->
      </div>
      <hr>
 
      <nav class="mt-6 list-none px-7">
        <div class="uppercase mb-4 text-[10px] font-bold tracking-widest text-gray-400/90">
          <span v-show="!toggleTextMenu">
            Métricas
          </span>
        </div>
        <Link as="button"  :href="route('list.Dashboard')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14.5px] hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <span v-show="!toggleTextMenu">Dashboard</span>
        </li>
      </Link>
        <div class="uppercase mt-9 mb-4 text-[10px] font-bold tracking-widest text-gray-400/90">
          <span v-show="!toggleTextMenu">
           Gestão de Cadastros
          </span>
        </div>
        
              
        

        <Link as="button" :href="route('list.DashboardCalendario')" v-if="$page.props.userPermissions.includes('list.DashboardCalendario')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
          </svg>
          <span v-show="!toggleTextMenu">Calendário &nbsp;&nbsp;</span>
        </li>
        </Link>



        <Link as="button" :href="route('list.ConfigCarros')" v-if="$page.props.userPermissions.includes('list.ConfigCarros')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
          </svg>
          <span v-show="!toggleTextMenu">Carros &nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link>

        <Link as="button" :href="route('list.ConfigVeiculos')" v-if="$page.props.userPermissions.includes('list.ConfigVeiculos')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75h15M7.5 16.5h0m9 0h0M5.25 16.5h13.5m-11.25-4.5V9.75a2.25 2.25 0 012.25-2.25h5.25a2.25 2.25 0 012.25 2.25v2.25M3 16.5h1.5m15 0H21m-3 0a1.5 1.5 0 11-3 0m-6 0a1.5 1.5 0 11-3 0M6 9l1.5-4.5m9 0L18 9" />
          </svg>
          <span v-show="!toggleTextMenu">Veículos &nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link>

        <Link as="button" :href="route('list.ConfigFuncionarios')" v-if="$page.props.userPermissions.includes('list.ConfigFuncionarios')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
          </svg>
          <span v-show="!toggleTextMenu">Funcionários &nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link>

        <Link as="button" :href="route('list.ConfigClientes')" v-if="$page.props.userPermissions.includes('list.ConfigClientes')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
          </svg>
          <span v-show="!toggleTextMenu">Clientes &nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link>

        <Link as="button" :href="route('list.ConfigAlugueis')" v-if="$page.props.userPermissions.includes('list.ConfigAlugueis')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
          </svg>
          <span v-show="!toggleTextMenu">Aluguéis &nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link>

        <!-- <Link as="button" :href="route('list.ConfigClientes')" v-if="$page.props.userPermissions.includes('list.ConfigClientes')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>

          <span v-show="!toggleTextMenu">Vendas &nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link> -->

        <li class="text-[14px] cursor-pointer mb-3" style="margin-top: 4%">
          <div @click="dropdownConfig = !dropdownConfig" class="flex text-gray-500/80 hover:text-proconph font-semibold space-x-3 items-center"
           v-if="$page.props.userPermissions.includes('list.companies') || $page.props.userPermissions.includes('list.Servicos') || $page.props.userPermissions.includes('list.Motorista') || $page.props.userPermissions.includes('list.Fornecedores') || $page.props.userPermissions.includes('list.Diarias')">
            <div class="w-6 h=6">     
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
              </svg>

            </div>
            <span v-show="!toggleTextMenu">Configurações</span>
            <div class="w-full" v-show="!toggleMenu">
              <svg :class="{'rotate-90': dropdownConfig}" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-auto transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>
          <SlideUpDown v-model="dropdownConfig" :duration="300" v-show="!toggleMenu">
            <ul class="ml-8 mt-2 mb-4 text-gray-400 font-normal space-y-3">
              <Link as="button" :href="route('list.company')" v-if="$page.props.userPermissions.includes('list.companies')">
              <li class="flex space-x-2 items-center hover:text-proconph">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
                <span>Empresas &nbsp;&nbsp;</span>
              </li>
              </Link>
                           
            </ul>
          </SlideUpDown>
        </li>

<!-- #ModificaAqui -->
     

        <div class="uppercase mt-9 mb-4 text-[10px] font-bold tracking-widest text-gray-400/90">
          <span v-show="!toggleTextMenu">
            Gestão do Sistema
          </span>
        </div>

        <Link as="button" :href="route('form.update.profile')" >
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
          </svg>
          <span v-show="!toggleTextMenu">Perfil &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link>

        <Link as="button" :href="route('list.users')" v-if="$page.props.userPermissions.includes('list.users')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph" >
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" fill="currentColor">
            <g>
              <path d="M0,0h24v24H0V0z" fill="none"></path>
            </g>
            <g>
              <g>
                <path d="M4,18v-0.65c0-0.34,0.16-0.66,0.41-0.81C6.1,15.53,8.03,15,10,15c0.03,0,0.05,0,0.08,0.01c0.1-0.7,0.3-1.37,0.59-1.98 C10.45,13.01,10.23,13,10,13c-2.42,0-4.68,0.67-6.61,1.82C2.51,15.34,2,16.32,2,17.35V20h9.26c-0.42-0.6-0.75-1.28-0.97-2H4z"></path>
                <path d="M10,12c2.21,0,4-1.79,4-4s-1.79-4-4-4C7.79,4,6,5.79,6,8S7.79,12,10,12z M10,6c1.1,0,2,0.9,2,2s-0.9,2-2,2 c-1.1,0-2-0.9-2-2S8.9,6,10,6z"></path>
                <path d="M20.75,16c0-0.22-0.03-0.42-0.06-0.63l1.14-1.01l-1-1.73l-1.45,0.49c-0.32-0.27-0.68-0.48-1.08-0.63L18,11h-2l-0.3,1.49 c-0.4,0.15-0.76,0.36-1.08,0.63l-1.45-0.49l-1,1.73l1.14,1.01c-0.03,0.21-0.06,0.41-0.06,0.63s0.03,0.42,0.06,0.63l-1.14,1.01 l1,1.73l1.45-0.49c0.32,0.27,0.68,0.48,1.08,0.63L16,21h2l0.3-1.49c0.4-0.15,0.76-0.36,1.08-0.63l1.45,0.49l1-1.73l-1.14-1.01 C20.72,16.42,20.75,16.22,20.75,16z M17,18c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S18.1,18,17,18z"></path>
              </g>
            </g>
          </svg>
          <span v-show="!toggleTextMenu">Usuários &nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link>
        <Link as="button" :href="route('list.permission')" v-if="$page.props.userPermissions.includes('list.users')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M0 0h24v24H0V0z" fill="none"></path>
            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm7 10c0 4.52-2.98 8.69-7 9.93-4.02-1.24-7-5.41-7-9.93V6.3l7-3.11 7 3.11V11zm-11.59.59L6 13l4 4 8-8-1.41-1.42L10 14.17z"></path>
          </svg>
          <span v-show="!toggleTextMenu">Permissões &nbsp;&nbsp;</span>
        </li>
        </Link>
        <Link  as="button" :href="route('list.SMTP')" v-if="$page.props.userPermissions.includes('list.SMTP')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6zM7.5 6h.008v.008H7.5V6zm2.25 0h.008v.008H9.75V6z" />
          </svg>
          <span v-show="!toggleTextMenu">SMTP &nbsp;&nbsp;</span>
        </li>
        </Link>



       
           <li class="text-[14px] cursor-pointer mb-3 space-x-3 space-y-3" style="margin-top:8%" > 
          <div @click="dropLogs = !dropLogs" class="flex text-gray-500/80 hover:text-proconph font-semibold space-x-3 items-center" v-if="$page.props.userPermissions.includes('list.logs') || $page.props.userPermissions.includes('list.logsErros')">
            <div class="w-6 h=6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
              </svg>
            </div>
            <span v-show="!toggleTextMenu">Logs</span>
            <div class="w-full" v-show="!toggleMenu">
              <svg :class="{'rotate-90': dropLogs}" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-auto transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>

          <SlideUpDown v-model="dropLogs" :duration="300" v-show="!toggleMenu">
            <ul class="mt-2 mb-2 text-gray-400 font-normal space-y-3">
              <Link as="button"  :href="route('list.logsUsuario')" v-if="$page.props.userPermissions.includes('list.logs')">
              <li class="flex space-x-1 items-center hover:text-proconph">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v3.75m-9.303 3.376C1.83 19.126 2.914 21 4.645 21h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 4.88c-.866-1.501-3.032-1.501-3.898 0L2.697 17.626zM12 17.25h.007v.008H12v-.008z" />
                </svg>
                <span>Rastreabilidade &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              </li>
              </Link>
              <Link as="button" :href="route('list.logsErros')" v-if="$page.props.userPermissions.includes('list.logsErros')">
              <li class="flex space-x-1 items-center hover:text-proconph">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.05 4.575a1.575 1.575 0 10-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 013.15 0v1.5m-3.15 0l.075 5.925m3.075.75V4.575m0 0a1.575 1.575 0 013.15 0V15M6.9 7.575a1.575 1.575 0 10-3.15 0v8.175a6.75 6.75 0 006.75 6.75h2.018a5.25 5.25 0 003.712-1.538l1.732-1.732a5.25 5.25 0 001.538-3.712l.003-2.024a.668.668 0 01.198-.471 1.575 1.575 0 10-2.228-2.228 3.818 3.818 0 00-1.12 2.687M6.9 7.575V12m6.27 4.318A4.49 4.49 0 0116.35 15m.002 0h-.002" />
               </svg>
                <span>Erros &nbsp;&nbsp; &nbsp;&nbsp;</span>
              </li>
              </Link>
                        
            </ul>
          </SlideUpDown>
        </li>
        <li class=" mt-4">
          <Link class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] hover:text-red-400" href="/logout" method="post">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" fill="currentColor">
            <g>
              <path d="M0,0h24v24H0V0z" fill="none"></path>
            </g>
            <g>
              <path d="M17,8l-1.41,1.41L17.17,11H9v2h8.17l-1.58,1.58L17,16l4-4L17,8z M5,5h7V3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h7v-2H5V5z"></path>
            </g>
          </svg>
          <span v-show="!toggleTextMenu">Sair &nbsp;&nbsp;</span>
          </Link>
        </li>
      </nav>
    </div>
  </SideBar>

  <SideBarMobile class="lg:hidden">
    <div class="bg-black/40 fixed top-0 h-full z-30 w-full" v-show="!toggleMenuMobile"></div>
    <button class="left-64 top-3 fixed z-30 text-white" @click="toggleMenuMobile = true" v-show="!toggleMenuMobile">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
    <div class="bg-white shadow-md w-60 h-full fixed top-0 z-30 transition-all duration-300" v-show="!toggleMenuMobile">
      <div class="p-4 flex h-16">
        <img class="mx-auto w-100" src="/images/logo_menu.png" alt="" srcset="">
      </div>
      <hr>
      <nav class="mt-6 list-none px-7">
        <div class="uppercase mb-4 text-[10px] font-bold tracking-widest text-gray-400/90">
          <span v-show="!toggleTextMenu">
            Métricas
          </span>
        </div>
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14.5px]">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <span v-show="!toggleTextMenu">Dashboard</span>
        </li>
        <div class="uppercase mt-9 mb-4 text-[10px] font-bold tracking-widest text-gray-400/90">
          <span v-show="!toggleTextMenu">
           Gestão de Cadastros
          </span>
        </div>
        

       
               

        <Link as="button" :href="route('list.DashboardCalendario')" v-if="$page.props.userPermissions.includes('list.DashboardCalendario')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2 hover:text-proconph">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
          </svg>
          <span v-show="!toggleTextMenu">Calendário &nbsp;&nbsp;</span>
        </li>
        </Link>

    


        <li class="text-[14px] cursor-pointer mb-3" style="margin-top: 4%">
          <div @click="dropdownConfig = !dropdownConfig" class="flex text-gray-500/80 hover:text-proconph font-semibold space-x-3 items-center"
           v-if="$page.props.userPermissions.includes('list.companies') || $page.props.userPermissions.includes('list.Servicos') || $page.props.userPermissions.includes('list.Motorista') || $page.props.userPermissions.includes('list.Fornecedores') || $page.props.userPermissions.includes('list.Diarias')">
            <div class="w-6 h=6">     
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
              </svg>

            </div>
            <span v-show="!toggleTextMenu">Configurações</span>
            <div class="w-full" v-show="!toggleMenu">
              <svg :class="{'rotate-90': dropdownConfig}" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-auto transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>
          <SlideUpDown v-model="dropdownConfig" :duration="300" v-show="!toggleMenu">
            <ul class="ml-8 mt-2 mb-4 text-gray-400 font-normal space-y-3">
              <Link as="button" :href="route('list.company')" v-if="$page.props.userPermissions.includes('list.companies')">
              <li class="flex space-x-2 items-center hover:text-proconph">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
                <span>Empresas &nbsp;&nbsp;</span>
              </li>
              </Link>
                           
            </ul>
          </SlideUpDown>
        </li>

<!-- #ModificaAqui -->
     

        <div class="uppercase mt-9 mb-4 text-[10px] font-bold tracking-widest text-gray-400/90">
          <span v-show="!toggleTextMenu">
            Gestão do Sistema
          </span>
        </div>

        <Link as="button" :href="route('form.update.profile')" >
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
          </svg>
          <span v-show="!toggleTextMenu">Perfil &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link>

        <Link as="button" :href="route('list.users')" v-if="$page.props.userPermissions.includes('list.users')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" fill="currentColor">
            <g>
              <path d="M0,0h24v24H0V0z" fill="none"></path>
            </g>
            <g>
              <g>
                <path d="M4,18v-0.65c0-0.34,0.16-0.66,0.41-0.81C6.1,15.53,8.03,15,10,15c0.03,0,0.05,0,0.08,0.01c0.1-0.7,0.3-1.37,0.59-1.98 C10.45,13.01,10.23,13,10,13c-2.42,0-4.68,0.67-6.61,1.82C2.51,15.34,2,16.32,2,17.35V20h9.26c-0.42-0.6-0.75-1.28-0.97-2H4z"></path>
                <path d="M10,12c2.21,0,4-1.79,4-4s-1.79-4-4-4C7.79,4,6,5.79,6,8S7.79,12,10,12z M10,6c1.1,0,2,0.9,2,2s-0.9,2-2,2 c-1.1,0-2-0.9-2-2S8.9,6,10,6z"></path>
                <path d="M20.75,16c0-0.22-0.03-0.42-0.06-0.63l1.14-1.01l-1-1.73l-1.45,0.49c-0.32-0.27-0.68-0.48-1.08-0.63L18,11h-2l-0.3,1.49 c-0.4,0.15-0.76,0.36-1.08,0.63l-1.45-0.49l-1,1.73l1.14,1.01c-0.03,0.21-0.06,0.41-0.06,0.63s0.03,0.42,0.06,0.63l-1.14,1.01 l1,1.73l1.45-0.49c0.32,0.27,0.68,0.48,1.08,0.63L16,21h2l0.3-1.49c0.4-0.15,0.76-0.36,1.08-0.63l1.45,0.49l1-1.73l-1.14-1.01 C20.72,16.42,20.75,16.22,20.75,16z M17,18c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S18.1,18,17,18z"></path>
              </g>
            </g>
          </svg>
          <span v-show="!toggleTextMenu">Usuários &nbsp;&nbsp;&nbsp;&nbsp;</span>
        </li>
        </Link>
        <Link as="button" :href="route('list.permission')" v-if="$page.props.userPermissions.includes('list.users')">
        <li class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px] mt-2">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M0 0h24v24H0V0z" fill="none"></path>
            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm7 10c0 4.52-2.98 8.69-7 9.93-4.02-1.24-7-5.41-7-9.93V6.3l7-3.11 7 3.11V11zm-11.59.59L6 13l4 4 8-8-1.41-1.42L10 14.17z"></path>
          </svg>
          <span v-show="!toggleTextMenu">Permissões &nbsp;&nbsp;</span>
        </li>
        </Link>
   
           <li class="text-[14px] cursor-pointer mb-3 space-x-3 space-y-3" style="margin-top:8%" > 
          <div @click="dropLogs = !dropLogs" class="flex text-gray-500/80 hover:text-proconph font-semibold space-x-3 items-center" v-if="$page.props.userPermissions.includes('list.logsUsuario') || $page.props.userPermissions.includes('list.logsErros') || $page.props.userPermissions.includes('list.logs')">
            <div class="w-6 h=6">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
              </svg>
            </div>
            <span v-show="!toggleTextMenu">Logs</span>
            <div class="w-full" v-show="!toggleMenu">
              <svg :class="{'rotate-90': dropLogs}" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-auto transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </div>
          </div>

          <SlideUpDown v-model="dropLogs" :duration="300" v-show="!toggleMenu">
            <ul class="mt-2 mb-2 text-gray-400 font-normal space-y-3">
              <Link as="button"  :href="route('list.logsUsuario')" v-if="$page.props.userPermissions.includes('list.logs')">
              <li class="flex space-x-1 items-center hover:text-proconph">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v3.75m-9.303 3.376C1.83 19.126 2.914 21 4.645 21h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 4.88c-.866-1.501-3.032-1.501-3.898 0L2.697 17.626zM12 17.25h.007v.008H12v-.008z" />
                </svg>
                <span>Rastreabilidade &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              </li>
              </Link>
              <Link as="button" :href="route('list.logsErros')" v-if="$page.props.userPermissions.includes('list.logsErros')">
              <li class="flex space-x-1 items-center hover:text-proconph">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.05 4.575a1.575 1.575 0 10-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 013.15 0v1.5m-3.15 0l.075 5.925m3.075.75V4.575m0 0a1.575 1.575 0 013.15 0V15M6.9 7.575a1.575 1.575 0 10-3.15 0v8.175a6.75 6.75 0 006.75 6.75h2.018a5.25 5.25 0 003.712-1.538l1.732-1.732a5.25 5.25 0 001.538-3.712l.003-2.024a.668.668 0 01.198-.471 1.575 1.575 0 10-2.228-2.228 3.818 3.818 0 00-1.12 2.687M6.9 7.575V12m6.27 4.318A4.49 4.49 0 0116.35 15m.002 0h-.002" />
               </svg>
                <span>Erros &nbsp;&nbsp; &nbsp;&nbsp;</span>
              </li>
              </Link>
                        
            </ul>
          </SlideUpDown>
        </li>
        <li class=" mt-4">
          <Link class="flex text-gray-500/80 font-semibold space-x-3 items-center text-[14px]" href="/logout" method="post">
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" fill="currentColor">
            <g>
              <path d="M0,0h24v24H0V0z" fill="none"></path>
            </g>
            <g>
              <path d="M17,8l-1.41,1.41L17.17,11H9v2h8.17l-1.58,1.58L17,16l4-4L17,8z M5,5h7V3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h7v-2H5V5z"></path>
            </g>
          </svg>
          <span v-show="!toggleTextMenu">Sair</span>
          </Link>
        </li>
      </nav>
    </div>
  </SideBarMobile>

  <div class="transition-all duration-300 p-6 mt-16" :class="{'lg:ml-60': !toggleMenu, 'lg:ml-20': toggleMenu}">
    <slot />
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import SlideUpDown from "vue3-slide-up-down";

const dropLogs = ref(false);

const dropdownConfig = ref(false);
const dropdownConfigConf = ref(false);

const dropdownAudit = ref(false);
const dropdownAuditConf = ref(false);

const dropdownReports = ref(false);
const dropdownReportsConf = ref(false);

const dropdownFinanceiro = ref(false);
const dropdownFinanceiroConf = ref(false);

const dropdownMotorista = ref(false);
const dropdownMotoristaConf = ref(false);


const toggleMenu = ref(false);
const toggleTextMenu = ref(false);

const toggleMenuMobile = ref(true);

watch(toggleMenu, () => {
  if (!toggleMenu.value) {
    setTimeout(() => {
      toggleTextMenu.value = toggleMenu.value;
    }, 150);
    return;
  }
  toggleTextMenu.value = toggleMenu.value;
});
</script>


<style scoped>
/* Firefox */
* {
  scrollbar-width: auto;
  scrollbar-color: #d1d1d1 #ffffff;
}

/* Chrome, Edge, and Safari */
*::-webkit-scrollbar {
  width: 12px;
}
/* Chrome, Edge, and Safari */

*::-webkit-scrollbar-track {
  background: #ffffff;
}

*::-webkit-scrollbar-thumb {
  background-color: #d1d1d1;
  border-radius: 10px;
  border: 3px solid #ffffff;
}
</style>

