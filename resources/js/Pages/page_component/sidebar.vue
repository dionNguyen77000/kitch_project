<template>

    <!-- give the sidebar z-50 class so its higher than the navbar if you want to see the logo -->
    <!-- you will need to add a little "X" button next to the logo in order to close it though -->
    <div id="sideBar" class="pb-2 sticky top-24 z-30 left-0 bg-gray-900">
      <div class="h-20 border flex justify-center items-center mb-4 ">
       <!-- <p class="font-semibold text-xl text-red-400 pl-4">DASHBOARD</p> -->
       <div id="dashboard">
         <router-link :to="{name:'DashboardHome'}">
            <div class="font-semibold text-xl text-red-400 pl-2 hover:text-red-700 cursor-pointer">
                 DASHBOARD
             </div>
          </router-link>
        </div>
      </div>  
       <div 
       v-if="getAuth.isFirstLevelUser|| getAuth.isSecondLevelUser" 
        class="mb-4 px-4">
        <p class="text-md text-gray-50 text-center font-semibold mb-1">
          USER 
          </p>   
          <!-- experiement dropdow menu section - see the comment code below -- may be implement later -->
          <!-- <div class="relative">
              <input type="checkbox" id="sortbox" class="hidden absolute">
              <label for="sortbox" class="flex items-center space-x-1 cursor-pointer">
              <span class="text-lg text-blue-400">Sort By</span>
              <svg class="h-4 w-4 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
              </label>

                  <div id="sortboxmenu" class="absolute mt-1 right-1 top-full min-w-max shadow rounded opacity-0 bg-gray-300 border border-gray-400 transition delay-75 ease-in-out z-10">
                  <ul class="block text-right text-gray-900">
                      <li><a href="#" class="block px-3 py-2 hover:bg-gray-200">Featured</a></li>
                      <li><a href="#" class="block px-3 py-2 hover:bg-gray-200">Newest</a></li>
                      <li><a href="#" class="block px-3 py-2 hover:bg-gray-200">Price: Low to High</a></li>
                      <li><a href="#" class="block px-3 py-2 hover:bg-gray-200">Price: High to Low</a></li>
                  </ul>
              </div>
          </div>  -->
            <router-link :to="{name:'User_Management'}">
            <div class="mb-1 w-full flex justify-center  md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                 User
             </div>
            </router-link>
              <router-link :to="{name:'Role'}">
              <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                Role
              </div>
             </router-link>

              <router-link :to="{name:'Permission'}">
              <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                Permission
              </div>
             </router-link>    
      </div>


      
      <div class="mb-4 px-4">
        <p class="pl-4 text-md text-gray-50 text-center font-semibold mb-1">STOCK</p>
      
        <template  v-if="getAuth.isFirstLevelUser|| getAuth.isSecondLevelUser" >
        <router-link :to="{name:'Supplier'}">
           <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
    
          Suppliers
            </div>
          </router-link>
      
         
          <router-link :to="{name:'Category'}">
          <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
            Categories
          </div>
          </router-link>

    
         
        <router-link :to="{name:'Unit'}">
        <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
            Units
        </div>            
        </router-link>

        </template>

        <router-link :to="{name:'Location'}">
        <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
            Locations
        </div>            
        </router-link>

       
         
          <router-link :to="{name:'Goods_Material'}">
            <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                Good Material
            </div>
          </router-link>

          <router-link :to="{name:'Intermediate_Product'}">
            <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                Intermediate Product
            </div>
          </router-link>
          <router-link :to="{name:'Daily_Emp_Work'}">
            <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                Daily Emp Work
            </div>
          </router-link>
          <router-link :to="{name:'Unit_Conversion'}">
            <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                Unit Conversion
            </div>
          </router-link>

         


        <!-- <div class="w-full flex items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
          <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
            <path d="M17.498,11.697c-0.453-0.453-0.704-1.055-0.704-1.697c0-0.642,0.251-1.244,0.704-1.697c0.069-0.071,0.15-0.141,0.257-0.22c0.127-0.097,0.181-0.262,0.137-0.417c-0.164-0.558-0.388-1.093-0.662-1.597c-0.075-0.141-0.231-0.22-0.391-0.199c-0.13,0.02-0.238,0.027-0.336,0.027c-1.325,0-2.401-1.076-2.401-2.4c0-0.099,0.008-0.207,0.027-0.336c0.021-0.158-0.059-0.316-0.199-0.391c-0.503-0.274-1.039-0.498-1.597-0.662c-0.154-0.044-0.32,0.01-0.416,0.137c-0.079,0.106-0.148,0.188-0.22,0.257C11.244,2.956,10.643,3.207,10,3.207c-0.642,0-1.244-0.25-1.697-0.704c-0.071-0.069-0.141-0.15-0.22-0.257C7.987,2.119,7.821,2.065,7.667,2.109C7.109,2.275,6.571,2.497,6.07,2.771C5.929,2.846,5.85,3.004,5.871,3.162c0.02,0.129,0.027,0.237,0.027,0.336c0,1.325-1.076,2.4-2.401,2.4c-0.098,0-0.206-0.007-0.335-0.027C3.001,5.851,2.845,5.929,2.77,6.07C2.496,6.572,2.274,7.109,2.108,7.667c-0.044,0.154,0.01,0.32,0.137,0.417c0.106,0.079,0.187,0.148,0.256,0.22c0.938,0.936,0.938,2.458,0,3.394c-0.069,0.072-0.15,0.141-0.256,0.221c-0.127,0.096-0.181,0.262-0.137,0.416c0.166,0.557,0.388,1.096,0.662,1.596c0.075,0.143,0.231,0.221,0.392,0.199c0.129-0.02,0.237-0.027,0.335-0.027c1.325,0,2.401,1.076,2.401,2.402c0,0.098-0.007,0.205-0.027,0.334C5.85,16.996,5.929,17.154,6.07,17.23c0.501,0.273,1.04,0.496,1.597,0.66c0.154,0.047,0.32-0.008,0.417-0.137c0.079-0.105,0.148-0.186,0.22-0.256c0.454-0.453,1.055-0.703,1.697-0.703c0.643,0,1.244,0.25,1.697,0.703c0.071,0.07,0.141,0.15,0.22,0.256c0.073,0.098,0.188,0.152,0.307,0.152c0.036,0,0.073-0.004,0.109-0.016c0.558-0.164,1.096-0.387,1.597-0.66c0.141-0.076,0.22-0.234,0.199-0.393c-0.02-0.129-0.027-0.236-0.027-0.334c0-1.326,1.076-2.402,2.401-2.402c0.098,0,0.206,0.008,0.336,0.027c0.159,0.021,0.315-0.057,0.391-0.199c0.274-0.5,0.496-1.039,0.662-1.596c0.044-0.154-0.01-0.32-0.137-0.416C17.648,11.838,17.567,11.77,17.498,11.697 M16.671,13.334c-0.059-0.002-0.114-0.002-0.168-0.002c-1.749,0-3.173,1.422-3.173,3.172c0,0.053,0.002,0.109,0.004,0.166c-0.312,0.158-0.64,0.295-0.976,0.406c-0.039-0.045-0.077-0.086-0.115-0.123c-0.601-0.6-1.396-0.93-2.243-0.93s-1.643,0.33-2.243,0.93c-0.039,0.037-0.077,0.078-0.116,0.123c-0.336-0.111-0.664-0.248-0.976-0.406c0.002-0.057,0.004-0.113,0.004-0.166c0-1.75-1.423-3.172-3.172-3.172c-0.054,0-0.11,0-0.168,0.002c-0.158-0.312-0.293-0.639-0.405-0.975c0.044-0.039,0.085-0.078,0.124-0.115c1.236-1.236,1.236-3.25,0-4.486C3.009,7.719,2.969,7.68,2.924,7.642c0.112-0.336,0.247-0.664,0.405-0.976C3.387,6.668,3.443,6.67,3.497,6.67c1.75,0,3.172-1.423,3.172-3.172c0-0.054-0.002-0.11-0.004-0.168c0.312-0.158,0.64-0.293,0.976-0.405C7.68,2.969,7.719,3.01,7.757,3.048c0.6,0.6,1.396,0.93,2.243,0.93s1.643-0.33,2.243-0.93c0.038-0.039,0.076-0.079,0.115-0.123c0.336,0.112,0.663,0.247,0.976,0.405c-0.002,0.058-0.004,0.114-0.004,0.168c0,1.749,1.424,3.172,3.173,3.172c0.054,0,0.109-0.002,0.168-0.004c0.158,0.312,0.293,0.64,0.405,0.976c-0.045,0.038-0.086,0.077-0.124,0.116c-0.6,0.6-0.93,1.396-0.93,2.242c0,0.847,0.33,1.645,0.93,2.244c0.038,0.037,0.079,0.076,0.124,0.115C16.964,12.695,16.829,13.021,16.671,13.334 M10,5.417c-2.528,0-4.584,2.056-4.584,4.583c0,2.529,2.056,4.584,4.584,4.584s4.584-2.055,4.584-4.584C14.584,7.472,12.528,5.417,10,5.417 M10,13.812c-2.102,0-3.812-1.709-3.812-3.812c0-2.102,1.71-3.812,3.812-3.812c2.102,0,3.812,1.71,3.812,3.812C13.812,12.104,12.102,13.812,10,13.812"></path>
          </svg>
          <span class="text-gray-500">Settings</span>
        </div> -->
      </div>
      <div v-if="getAuth.isFirstLevelUser|| getAuth.isSecondLevelUser || getPermissionNames.includes('Order_Management')"  
      class="mb-4 px-4"
      >
        <p class="pl-4 text-md text-gray-50 text-center font-semibold mb-1">Order</p>
         
          <router-link :to="{name:'Orders_To_Suppliers'}">
          <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
            Orders_To_Suppliers
          </div>
          </router-link>

          <router-link :to="{name:'Invoices_From_Suppliers'}">
          <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
            Invoices_From_Suppliers
          </div>
          </router-link>

          <router-link :to="{name:'Miscellaneous_Invoices'}">
          <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
            Miscellaneous_Invoices
          </div>
          </router-link>
    
        <!-- <div class="w-full flex items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
          <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
            <path d="M17.498,11.697c-0.453-0.453-0.704-1.055-0.704-1.697c0-0.642,0.251-1.244,0.704-1.697c0.069-0.071,0.15-0.141,0.257-0.22c0.127-0.097,0.181-0.262,0.137-0.417c-0.164-0.558-0.388-1.093-0.662-1.597c-0.075-0.141-0.231-0.22-0.391-0.199c-0.13,0.02-0.238,0.027-0.336,0.027c-1.325,0-2.401-1.076-2.401-2.4c0-0.099,0.008-0.207,0.027-0.336c0.021-0.158-0.059-0.316-0.199-0.391c-0.503-0.274-1.039-0.498-1.597-0.662c-0.154-0.044-0.32,0.01-0.416,0.137c-0.079,0.106-0.148,0.188-0.22,0.257C11.244,2.956,10.643,3.207,10,3.207c-0.642,0-1.244-0.25-1.697-0.704c-0.071-0.069-0.141-0.15-0.22-0.257C7.987,2.119,7.821,2.065,7.667,2.109C7.109,2.275,6.571,2.497,6.07,2.771C5.929,2.846,5.85,3.004,5.871,3.162c0.02,0.129,0.027,0.237,0.027,0.336c0,1.325-1.076,2.4-2.401,2.4c-0.098,0-0.206-0.007-0.335-0.027C3.001,5.851,2.845,5.929,2.77,6.07C2.496,6.572,2.274,7.109,2.108,7.667c-0.044,0.154,0.01,0.32,0.137,0.417c0.106,0.079,0.187,0.148,0.256,0.22c0.938,0.936,0.938,2.458,0,3.394c-0.069,0.072-0.15,0.141-0.256,0.221c-0.127,0.096-0.181,0.262-0.137,0.416c0.166,0.557,0.388,1.096,0.662,1.596c0.075,0.143,0.231,0.221,0.392,0.199c0.129-0.02,0.237-0.027,0.335-0.027c1.325,0,2.401,1.076,2.401,2.402c0,0.098-0.007,0.205-0.027,0.334C5.85,16.996,5.929,17.154,6.07,17.23c0.501,0.273,1.04,0.496,1.597,0.66c0.154,0.047,0.32-0.008,0.417-0.137c0.079-0.105,0.148-0.186,0.22-0.256c0.454-0.453,1.055-0.703,1.697-0.703c0.643,0,1.244,0.25,1.697,0.703c0.071,0.07,0.141,0.15,0.22,0.256c0.073,0.098,0.188,0.152,0.307,0.152c0.036,0,0.073-0.004,0.109-0.016c0.558-0.164,1.096-0.387,1.597-0.66c0.141-0.076,0.22-0.234,0.199-0.393c-0.02-0.129-0.027-0.236-0.027-0.334c0-1.326,1.076-2.402,2.401-2.402c0.098,0,0.206,0.008,0.336,0.027c0.159,0.021,0.315-0.057,0.391-0.199c0.274-0.5,0.496-1.039,0.662-1.596c0.044-0.154-0.01-0.32-0.137-0.416C17.648,11.838,17.567,11.77,17.498,11.697 M16.671,13.334c-0.059-0.002-0.114-0.002-0.168-0.002c-1.749,0-3.173,1.422-3.173,3.172c0,0.053,0.002,0.109,0.004,0.166c-0.312,0.158-0.64,0.295-0.976,0.406c-0.039-0.045-0.077-0.086-0.115-0.123c-0.601-0.6-1.396-0.93-2.243-0.93s-1.643,0.33-2.243,0.93c-0.039,0.037-0.077,0.078-0.116,0.123c-0.336-0.111-0.664-0.248-0.976-0.406c0.002-0.057,0.004-0.113,0.004-0.166c0-1.75-1.423-3.172-3.172-3.172c-0.054,0-0.11,0-0.168,0.002c-0.158-0.312-0.293-0.639-0.405-0.975c0.044-0.039,0.085-0.078,0.124-0.115c1.236-1.236,1.236-3.25,0-4.486C3.009,7.719,2.969,7.68,2.924,7.642c0.112-0.336,0.247-0.664,0.405-0.976C3.387,6.668,3.443,6.67,3.497,6.67c1.75,0,3.172-1.423,3.172-3.172c0-0.054-0.002-0.11-0.004-0.168c0.312-0.158,0.64-0.293,0.976-0.405C7.68,2.969,7.719,3.01,7.757,3.048c0.6,0.6,1.396,0.93,2.243,0.93s1.643-0.33,2.243-0.93c0.038-0.039,0.076-0.079,0.115-0.123c0.336,0.112,0.663,0.247,0.976,0.405c-0.002,0.058-0.004,0.114-0.004,0.168c0,1.749,1.424,3.172,3.173,3.172c0.054,0,0.109-0.002,0.168-0.004c0.158,0.312,0.293,0.64,0.405,0.976c-0.045,0.038-0.086,0.077-0.124,0.116c-0.6,0.6-0.93,1.396-0.93,2.242c0,0.847,0.33,1.645,0.93,2.244c0.038,0.037,0.079,0.076,0.124,0.115C16.964,12.695,16.829,13.021,16.671,13.334 M10,5.417c-2.528,0-4.584,2.056-4.584,4.583c0,2.529,2.056,4.584,4.584,4.584s4.584-2.055,4.584-4.584C14.584,7.472,12.528,5.417,10,5.417 M10,13.812c-2.102,0-3.812-1.709-3.812-3.812c0-2.102,1.71-3.812,3.812-3.812c2.102,0,3.812,1.71,3.812,3.812C13.812,12.104,12.102,13.812,10,13.812"></path>
          </svg>
          <span class="text-gray-500">Settings</span>
        </div> -->
      </div>
      <div v-if="getAuth.isFirstLevelUser|| getAuth.isSecondLevelUser"  
      class="mb-4 px-4"
      >
        <p class="pl-4 text-md text-gray-50 text-center font-semibold mb-1"> Settings</p>
         
          <router-link :to="{name:'Activity_Log'}">
          <div class="mb-1 w-full flex justify-center md:justify-start items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
            Activity Log
          </div>
          </router-link>

      </div>

    <!-- <div class="mb-4 px-4">
      <p class="pl-4 text-sm text-gray-50 font-semibold mb-1">MAIN</p>
      <div class="w-full flex items-center text-blue-400 h-8 pl-4 bg-gray-200 hover:bg-gray-200 rounded-lg cursor-pointer">
        <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
          <path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"></path>
        </svg>
        <span class="text-gray-500">Dashboard</span>
      </div>
      <div class="w-full flex items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
        <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
          <path d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156 M5.872,17.019h-2.89v-3.117h2.89V17.019zM9.587,17.019h-2.89V7.1h2.89V17.019z M13.303,17.019h-2.89v-6.651h2.89V17.019z M17.019,17.019h-2.891V2.982h2.891V17.019z"></path>
        </svg>
        <span class="text-gray-500">Analytics</span>
      </div>
      <div class="w-full flex items-center text-blue-400 h-8 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
        <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
          <path d="M17.283,5.549h-5.26V4.335c0-0.222-0.183-0.404-0.404-0.404H8.381c-0.222,0-0.404,0.182-0.404,0.404v1.214h-5.26c-0.223,0-0.405,0.182-0.405,0.405v9.71c0,0.223,0.182,0.405,0.405,0.405h14.566c0.223,0,0.404-0.183,0.404-0.405v-9.71C17.688,5.731,17.506,5.549,17.283,5.549 M8.786,4.74h2.428v0.809H8.786V4.74z M16.879,15.26H3.122v-4.046h5.665v1.201c0,0.223,0.182,0.404,0.405,0.404h1.618c0.222,0,0.405-0.182,0.405-0.404v-1.201h5.665V15.26z M9.595,9.583h0.81v2.428h-0.81V9.583zM16.879,10.405h-5.665V9.19c0-0.222-0.183-0.405-0.405-0.405H9.191c-0.223,0-0.405,0.183-0.405,0.405v1.215H3.122V6.358h13.757V10.405z"></path>
        </svg>
        <span class="text-gray-500">Inventory</span>
      </div>
      
    </div> -->

     


    </div>
</template>

<script>
import { mapState } from 'vuex'
import {mapGetters, mapActions} from 'vuex'
export default {
  data() {
        return {
            
        }
    },
    name: 'Sidebar',
    computed: {
        ...mapState(['sideBarOpen']),
         ...mapGetters({
           getAuth: 'auth/getAuth'
         }),
          getPermissionNames(){
              const permissionNameArray = _.map(this.getAuth.user.permissions, 'name');
              return permissionNameArray;
          },

          // haveOrderManagementPermission(){
          //   let isCorrect = false;
          //   if (this.getPermissionNames.includes('Order_Management')) 
          //   {
          //       isCorrect = true;
          //       break;
          //   }
                
          //   return isCorrect;

          // },

    },
    methods: {
       
    }
}
</script>

<style>

#sideBar a  {
    padding-left: 3px;
    display: block;
    border-radius: 0.5rem;
    margin-bottom: 1px;
}

#sideBar .router-link-active{
    color:white;
    background-color:white;
}

#dashboard .router-link-active{
      background-color:black;
}

/* #sortbox:checked ~ #sortboxmenu {
      opacity: 1;
  } */


</style>

