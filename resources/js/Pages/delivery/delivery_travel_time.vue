<template>
  <div id="delivery_setting" class="p-6"> 
        <div class="min-w-screen min-h-screen bg-gray-100 flex justify-center rounded-lg shadow-md">
            <loading v-model:active="isLoading"
                 :can-cancel="true"
                 :is-full-page="fullPage"/>       
            <div class="w-full p-1">
            <div class="flex justify-between pt-4">
                <div class="text-2xl font-semibold uppercase"> Table Deilvery Travel</div>
                <div>
                    <a href="#" 
                    class="p-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                    v-if="(getAuth.isFirstLevelUser || getAuth.includesisSecondLevelUser || getAuth.isThirdLevelUser) && response.allow.creation"
                    @click.prevent="creating.active = !creating.active">
                    {{ creating.active ? 'Hide' : 'New record' }}
                    </a>
                </div>               
            </div>
            <!-- New Record section  -->
            <div class="flex justify-center" v-if="response.allow.creation && creating.active">
                <div class="w-10/12 md:w-8/12 lg:6/12 p-6 rounded-lg">
                <h3 class="text-xl text-gray text-center font-bold  p-3 mb-1">New</h3>
                    <form action="#" @submit.prevent="store">
                        <!-- @csrf -->
                        <div class="mb-2" v-for="column in response.updatable" :key="column" >

                             <template v-if="column=='destination_one_id'">
                                <label :for="column"  class="w-1/2">Destination 1 : </label>
        
                                <select :name="column" :id="column" v-model="creating.form[column]"
                                class="bg-gray-100 border-2 w-1/2 p-1 rounded-lg">
                                    <option :value="index" v-for="option,index in response.destinationOptions" :key="option">
                                        {{option}}
                                    </option>
                                </select>
                            </template> 
                             <template v-else-if="column=='destination_two_id'">
                                <label :for="column"  class="w-1/2">Destination 2 : </label>
        
                                <select :name="column" :id="column" v-model="creating.form[column]"
                                class="bg-gray-100 border-2 w-1/2 p-1 rounded-lg">
                                    <option :value="index" v-for="option,index in response.destinationOptions" :key="option">
                                        {{option}}
                                    </option>
                                </select>
                            </template> 
                            <template v-else>
                                <label :for="column" class="sr-only"> </label>
                                <input type="text" :name="column" :id="column" :placeholder="column" class="bg-gray-100 border-2 w-full p-1 rounded-lg"
                                :class="{ 'border-red-500': creating.errors[column] }"
                                v-model="creating.form[column]">
                                <div class="text-red-500 mt-2 text-sm" v-if="creating.errors[column]">
                                        <strong>{{ creating.errors[column][0] }}</strong>
                                </div>
                            </template>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-800 text-white px-4 py-2 rounded">Create</button>
                        </div>
                    
                    </form>

                </div>
        </div>  <!-- End New Record Section -->
        
        <!-- show hide column section -->
        <div id="show_hide_section" class="text-center mx-4 space-y-2">
            <p> <b>Show Hide Column </b></p>
            <ul id="hide_show_column_section" class="width-3/4 flex flex-wrap justify-center">
                <li  class="mr-3" v-for="column in response.displayable" :key="column">
                    <input type="checkbox" 
                    :value="column" 
                    :id="column" 
                    :checked="hideColumns.includes(column)"
                    v-model="hideColumns">
                    {{response.custom_columns[column] || column}}
                </li>
            </ul>
          
        </div>

        <div class="flex sm:flex-row flex-col">
            <div class="flex flex-row mb-1 sm:mb-0">
               <!-- delete with selected -->
                    <div class="dropdown inline-block relative z-10"  v-if="selected.length">
                        <button 
                        class="border-blue-500 border horver:bg-blue-700 text-gray-700 font-semibold py-1 px-1 inline-flex items-center"
                        @click.prevent="selected_dropdown_active = !selected_dropdown_active"
                        >
                        <span class="text-sm">With Selected</span>
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg>
                        </button>
                        <ul class="dropdown-menu absolute text-gray-700 pt-1"
                        :class="selected_dropdown_active ? 'block': 'hidden'"
                        >
                        <li><a class=" text-sm bg-blue-200 hover:bg-blue-700 hover:text-white py-1 px-6 block whitespace-no-wrap" href="#" @click.prevent = "destroy(selected)">Delete</a></li>
                        </ul>
                    </div>

            
                <div class="relative">
                    <select v-model = "limit" @change="getRecords"
                        class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 pl-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="">All</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-1 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
          
            <div class="relative">
                <select v-model="selected_destination_one" @change="getRecords"
                    class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 pl-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option  value= 'All'>Destination 1</option>
                        
                    <option v-for="option,index in response.destinationOptions" :value="index" :key="option">
                        {{option}} 
                    </option>                   
                </select>          
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pl-3 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
            <div class="relative">
                <select v-model="selected_destination_two" @change="getRecords"
                    class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 pl-1 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option  value= 'All'>Destination 2</option>
                        
                    <option v-for="option,index in response.destinationOptions" :value="index" :key="option">
                        {{option}} 
                    </option>                   
                </select>          
                <div
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pl-3 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
           
            
            <div class="block relative">
                <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                        <path
                            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                        </path>
                    </svg>
                </span>
                <input v-model="quickSearchQuery" placeholder="Quick Search"
                    class="rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700" />
            </div>
        </div>
    </div> 
        <!-- start Table -->
        
            <div  v-if="filteredRecords.length" class="bg-white shadow-md rounded my-3  overflow-x-auto">
                <table class="min-w-max w-full table-auto">
                <!-- Table Heading Section -->
                    <thead class="py-2">
                        <tr class="py-2 bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="p-1" 
                             v-if="(getAuth.isFirstLevelUser || getAuth.includesisSecondLevelUser) && canSelectItems"
                             >
                                    <input type="checkbox" 
                                    @change="toggleSelectAll" 
                                    :checked="filteredRecords.length === selected.length"
                                    >
                            </th>
                        <!--  Loop through column in response.displayable  -->
                            <template v-for="column in response.displayable" :key="column">
                            <!-- Table Heading - Columns not allow to show in any mode-->
                            <template v-if="unshownColumns.includes(column)">
                            </template>
                             <!-- Table Heading - Columns not allow to show according to the level of user-->
                            <template v-else-if="columnsNotAllowToShowAccordingToUserLevel.includes(column)">
                            </template>
                              <!-- Table Heading - Edit Mode-->
                            <template v-else-if="editing.id">
                                <!-- Table heading not shown in Edit Mode-->
                                <template v-if="unshownColumnsInEditMode.includes(column)
                                    || hideColumns.includes(column) ||!isUpdatable(column)">
                                </template>
                                <!-- Table heading shown in Edit Mode -->
                                <template v-else>
                                    <th class="text-left p-1"
                                    :class="{ 'text-center': textCenterColumns.includes(column) }"
                                    >
                                        <span class="sortable" @click="sortBy(column)">{{response.custom_columns[column] || column}}</span>
                                        <div 
                                        class="arrow" 
                                        v-if="sort.key===column"
                                        :class="{ 'arrow--asc': sort.order === 'asc', 'arrow--desc': sort.order === 'desc'}">
                                        </div> 
                                    </th>
                                </template>
                            </template>
                            <!-- heading -not in edit mode-->
                            <template v-else>
                                <th  
                                class="text-left p-1" 
                                :class="{ 'text-center': textCenterColumns.includes(column) 
                                }"
                                v-if="!hideColumns.includes(column)"
                                >
                                    <span class="sortable" @click="sortBy(column)">{{response.custom_columns[column] || column}}</span>
                                    <div 
                                    class="arrow" 
                                    v-if="sort.key===column"
                                    :class="{ 'arrow--asc': sort.order === 'asc', 'arrow--desc': sort.order === 'desc'}">
                                    </div> 
                                </th>
                            </template>
                            </template>
                            <th v-if="getAuth.isFirstLevelUser || getAuth.includesisSecondLevelUser || getAuth.isThirdLevelUser" class="text-left">Actions </th>                          
                        </tr>
                    </thead>
                    <!-- End Table Heading -->
                     <!-- Row (Records) Section -->                    
                    <tbody class="text-gray-600 text-sm">
                        <!-- Loop Through each records getting from controller -->
                        <tr v-for="record in filteredRecords" :key="record"  class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100">                          
                            <td v-if="(getAuth.isFirstLevelUser || getAuth.includesisSecondLevelUser) && canSelectItems" 
                            class=" text-center">
                                <input type="checkbox" :value="record.id" v-model="selected">
                            </td>
                            <!-- Loop through each column-->
                            <template v-for="columnValue,column in record" :key="column">
                              <!-- Columns not allow to show in any mode-->
                            <template v-if="unshownColumns.includes(column)">
                            </template>
                            <!-- Columns not allow to show according to level of user-->                           
                            <template v-else-if="columnsNotAllowToShowAccordingToUserLevel.includes(column)">
                            </template>
                            <!-- Edit Mode-->
                            <template v-else-if="editing.id">  
                                 <!-- Edit Mode - column not show -->
                                <template v-if="unshownColumnsInEditMode.includes(column)
                                        || hideColumns.includes(column) || !isUpdatable(column)">
                                </template>
                                <!-- if the record currently edit -->               
                                <template v-else-if="editing.id === record.id">

                                    <template v-if="column==('destination_one_id') || column==('destination_two_id')">
                                        <td class="p-1 text-left"  
                                        :class="{ 'text-center': textCenterColumns.includes(column)}" 
                                        v-if="response.displayable.includes(column)"> 
                                        <select 
                                        class='w-full rounded-r rounded-l sm:rounded-l-none border border-gray-400 pl-1 pr-1 py-1 text-sm text-gray-700'
                                        :class="{
                                            'bg-pink-200' : columnsNotAllowToEditAccordingToUserLevel.includes(column),
                                            'text-center': textCenterColumns.includes(column)
                                        }"
                                        :name="column" :id="column" 
                                        :disabled= "columnsNotAllowToEditAccordingToUserLevel.includes(column)" 
                                        v-model="editing.form[column]"
                                        >
                                            <template v-for="option,index in response.destinationOptions" >   
                                                <template v-if="record.id != option.id">                  
                                                    <option :value="index" :key="option">
                                                        {{option}} 
                                                    </option>
                                                </template>
                                            </template>   
                                        </select>
                                        </td>   
                                    </template>    
                                    <template v-else>
                                    <td class="p-1 text-left"  
                                    :class="{ 'text-center': textCenterColumns.includes(column)}" 
                                    v-if="response.displayable.includes(column)"> 
                                        <input type="text"  
                                        class="rounded-r rounded-l sm:rounded-l-none border border-gray-400 pl-1 pr-1 py-1 bg-white text-sm text-gray-700 focus:bg-white"
                                        v-model="editing.form[column]"
                                        :class="{ 'border-3 border-red-700': editing.errors[column],
                                        'text-center': textCenterColumns.includes(column)
                                         }"
                                        > 
                                        <br>
                                        <span v-if="editing.errors[column]" class="text-red-700 font-bold">
                                            <strong>{{ editing.errors[column][0] }}</strong>
                                        </span>
                                    </td>    
                                    </template>
                                </template> <!-- End the row current edit -->
                                <!-- Edit Mode - for rows not currently edit -->
                                <template v-else>
                                </template> <!-- End Edit Mode - the rows current not edit -->
                            </template>  <!-- End Edit Mode -->
                            <!-- Not in Edit Mode-->
                            <template v-else>
                                 <template v-if="hideColumns.includes(column)">
                                </template>
                                
                                 <template v-else>
                                    <template v-if="column=='destination_one_id' || column=='destination_two_id'">
                                         <td class="p-1 text-left"  
                                            :class="{ 'text-center': textCenterColumns.includes(column) }"
                                            v-if="response.displayable.includes(column)"> 
                                                <span class="font-medium" >{{response.destinationOptions[columnValue]}}</span>
                                        </td>
                                    </template>
                                    <template v-else>
                                    <td class="p-1 text-left"  
                                    :class="{ 'text-center': textCenterColumns.includes(column) }"
                                    v-if="response.displayable.includes(column)"> 
                                       <!-- Thumbnail Image -->
                                            <template v-if="column=='street/road'">
                                                    <span class="font-medium" >{{columnValue}}</span>
                                            </template>
                                            <template v-else>
                                              <span class="font-medium" >
                                                    {{(dollarsSymbolColumns.includes(column) && columnValue != null) ?'$' : '' }}{{columnValue}}
                                              </span>
                                            </template>
                                    </td>
                                    </template>
                                </template>
                            </template> <!-- End Not in Edit Mode -->                               
                               
                        </template> <!-- end Loop through each column of rows-->

                         <!-- Last Column - Actions -->  
                            
                             <td v-if="getAuth.isFirstLevelUser || getAuth.includesisSecondLevelUser || getAuth.isThirdLevelUser">
                             <div v-if="!editing.id">
                                
                                <a href="#" @click.prevent="edit(record)"  v-if="editing.id !== record.id"
                                class=" mr-1 py-1 px-3 shadow-md rounded-full bg-yellow-500 text-white text-sm hover:bg-yellow-700 focus:outline-none"
                                >
                                Edit
                                </a>   
                                 <a href="#" 
                                @click.prevent="destroy(record.id)" 
                                v-if="response.allow.deletion && editing.id !== record.id 
                                && canSelectItems" 
                                class=" mr-1 py-1 px-2 shadow-md rounded-full bg-red-400 text-white text-sm hover:bg-red-700 focus:outline-none"
                                >
                                Delete
                                </a>  
                            </div>

                            <div>
                                <template v-if="editing.id === record.id"> 
                                <a href="#" @click.prevent="editing.id = null"  v-if="editing.id === record.id"
                                class="p-1 bg-transparent border border-gray-600  shadow-md rounded-full  text-grey text-sm hover:bg-green-700 hover:text-white focus:outline-none"
                                >
                                Cancel
                                </a>  

                                <a href="#" @click.prevent="update"  v-if="editing.id === record.id"
                                class="m-2 py-2 px-3 shadow-md rounded-full bg-blue-300 text-white text-sm hover:bg-blue-700 focus:outline-none"
                                >
                                Save
                                </a>    
                                </template>
                            </div>
                        </td> 

                        </tr>
                    </tbody>
                    <p class="mt-2 text-red-600 text-center text-sm" >Count : {{filteredRecords.length}}</p>
                </table>
            </div>
            <p v-else>No results</p>
        </div>
    </div>
</div>
    
</template>



<script>
import Loading from 'vue-loading-overlay';
import { mapGetters, mapState } from 'vuex'
import queryString from 'query-string' //use package query-string npm install query-string
import redirectIfNotFirstLevelUser from '../../router/middleware/redirectIfNotFirstLevelUser'
import redirectIfNotSecondLevelUser from '../../router/middleware/redirectIfNotSecondLevelUser'


export default {
  middleware: [
          redirectIfNotFirstLevelUser,redirectIfNotSecondLevelUser
      ],
    props: [],    
    components: {Loading},
   data() {
            return {
                response: {
                    table: '',
                    displayable: [],
                    records: [],
                    allow: {},
                },
                sort: {
                    key: 'id',
                    order: 'desc'
                },
                creating: {
                    active: false,
                    form: {},
                    errors: [],
                },
                editing: {
                    id: null,
                    form: {},
                    errors: []
                },
                // search:{
                //     value: '',
                //     operator:'equals',
                //     column: 'id'
                // },
                
                
                isLoading: false,
                fullPage: true,

                selected: [],

                  // Hide Column Section : checkbox of columns that completely disappear
                unshownColumns:['img'],

                // columns hidden - can be show by unclick the radio buttons
                hideColumns:['slug'],
                // columns unshown in edit mode
                unshownColumnsInEditMode:[],

                // columns unshown according to user levels
                secondLevel_ColumnNotAllowsToShow: [
                                    
                ],
 
                thirdLevel_ColumnNotAllowsToShow: [
                    
                ],     
                            
                fourthLevel_ColumnNotAllowsToShow: [
                ],

                // columns does not allow to edit according to user levels
                secondLevel_ColumnNotAllowsToEdit: [
                
                ],                

                thirdLevel_ColumnNotAllowsToEdit: [
                     
                ],     
                            
                fourthLevel_ColumnNotAllowsToEdit: [
                   
                ],
                
                textCenterColumns:['destination_one_id','destination_two_id','estimated_duration'],
                dollarsSymbolColumns:[],
                
                // fillter section setting
                limit: '',
                quickSearchQuery: '',
                selected_destination_one:'All',
                selected_destination_two:'All',

                selected_dropdown_active: false,

                  //image upload
                image:null,
                imagePreview:null,
                imagePreviewUpdate:null,               
                currentPreviewUpdateId:null,  

                 // showIMGModal: false,
                clickImgSliderModalId : null,

                
               
            }
        },
       
 computed: {
       ...mapGetters({
            getAuth: 'auth/getAuth',
            firstLevelUsers: 'firstLevelUsers' ,
            secondLevelUsers: 'secondLevelUsers' ,
            thirdLevelUsers: 'thirdLevelUsers' ,
            fourthLevelUsers: 'fourthLevelUsers' ,

            }),

    ...mapState(['sideBarOpen']),
      filteredRecords () {
                // return this.response.records;
                let data = this.response.records;                

                // quick search query
                data = data.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.quickSearchQuery.toLowerCase()) > -1
                    })
                })
                
            //  sort data according to clicking the head column
            if (this.sort.key) {
                data = _.orderBy(data, (i) => { //lodash 
                    
                    let value = i[this.sort.key]
                    
                    if (!isNaN(parseFloat(value)) && isFinite(value)) {
                        return parseFloat(value)
                    }

                    return String(i[this.sort.key]).toLowerCase()
                }, this.sort.order)
            }
            return data
        },
            canSelectItems() {
                return this.filteredRecords.length <= 500
            },
         
            columnsNotAllowToShowAccordingToUserLevel(){
                if(this.getAuth.isFirstLevelUser) {
                    return [] ;
                } else if (this.getAuth.includesisSecondLevelUser){
                    return this.secondLevel_ColumnNotAllowsToShow;
                } 
                else if (this.getAuth.isThirdLevelUser){
                    return this.thirdLevel_ColumnNotAllowsToShow ;
                } 
                else if (this.getAuth.isFourthLevelUser){
                    return this.fourthLevel_ColumnNotAllowsToShow ;
                } 
                return this.fourthLevel_ColumnNotAllowsToShow;
            },

            columnsNotAllowToEditAccordingToUserLevel(){
                if(this.getAuth.isFirstLevelUser) {
                    return [] ;
                } else if (this.getAuth.includesisSecondLevelUser){
                    return this.secondLevel_ColumnNotAllowsToEdit;
                } 
                else if (this.getAuth.isThirdLevelUser){
                    return this.thirdLevel_ColumnNotAllowsToEdit ;
                } 
                else if (this.getAuth.isFourthLevelUser){
                    return this.fourthLevel_ColumnNotAllowsToEdit ;
                } 
                return this.fourthLevel_ColumnNotAllowsToEdit;
            },

            columnsNotAllowToShowAccordingToUserLevel(){
                if(this.getAuth.isFirstLevelUser) {
                    return [] ;
                } else if (this.getAuth.includesisSecondLevelUser){
                    return this.secondLevel_ColumnNotAllowsToShow;
                } 
                else if (this.getAuth.isThirdLevelUser){
                    return this.thirdLevel_ColumnNotAllowsToShow;
                } 
                else if (this.getAuth.isFourthLevelUser){
                    return this.fourthLevel_ColumnNotAllowsToShow;
                } 
                return this.fourthLevel_ColumnNotAllowsToShow;
            },

             
  },

   methods: {
            
            getRecords(){
                return axios.get(`/api/datatable/delivery_travel_times?${this.getQueryParameters()}`).then((response)=> {
                    this.response = response.data.data;
                })
            },
            getQueryParameters () {
                return queryString.stringify({
                    limit: this.limit,
                    selectedDestinationOne: this.selected_destination_one,            
                    selectedDestinationTwo: this.selected_destination_two,            

                    // ...this.search
                })
                    
            },
            sortBy(column){
            this.sort.key = column
            this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc'
            },
            edit (record) {
                this.editing.errors = []
                this.editing.id = record.id
                this.editing.form = _.pick(record, this.response.updatable)
            },
            isUpdatable (column) {
                return this.response.updatable.includes(column)
            },
            toggleSelectAll () {
                if (this.selected.length == this.filteredRecords.length) {
                    this.selected = []
                    return
                }

                this.selected = _.map(this.filteredRecords, 'id')
            },
            update () {
                this.isLoading = true
                axios.patch(`/api/datatable/delivery_travel_times/${this.editing.id}`, this.editing.form).then((response) => {
                    this.isLoading = false
                    this.getRecords().then(() => {
                        this.editing.id = null
                        this.editing.form = null
                       
                      
                    })
                }).catch((error) => {
                    this.isLoading = false
                    if (error.response.status === 422) {                        
                        this.editing.errors = error.response.data.errors
                    }
                })
            },
            store () {    
                this.isLoading = true
                axios.post(`/api/datatable/delivery_travel_times`, this.creating.form).then((response) => {
                    this.isLoading = false
                    if(this.image) {
                        let data = new FormData;
                        data.append('image', this.image)
                
                        //save image 
                        axios.post(`/api/datatable/delivery_travel_times/saveImage/${response.data.id}`, data).then(()=>{
                        this.getRecords().then(() => {                               
                            this.image =null;
                            this.imagePreview = null;
                            this.imagePreviewUpdate = null;

                          
                            })
                        }).catch((error) => {
                            this.isLoading = false
                            if (error.response.status === 422) {
                                this.creating.errors = error.response.data.errors                       
                            }

                        })
                    } 
                    this.getRecords().then(() => {
                        this.creating.active = true
                        this.creating.form = {}
                        this.creating.errors = []

                    })
                }).catch((error) => {
                    this.isLoading = false
                    if (error.response.status === 422) {
                        this.creating.errors = error.response.data.errors
                        
                    }
                })
            },

            exportPDF(){
                axios.get(`/api/datatable/delivery_travel_times/createPDF`,
                      {responseType: 'arraybuffer'}
                )
                
                .then((response)=>{
                     //code to download file after generating
                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');
                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'goods.pdf');
                    document.body.appendChild(fileLink);
                    fileLink.click();
                    console.log(fileLink);
                }).catch((error) => {
                    this.isLoading = false
                    if (error.response.status === 422) {
                        this.creating.errors = error.response.data.errors                       
                    }

                })
            },
               
            destroy(record){
                if(!window.confirm(`Are you sure?`)){
                    return
                }
                this.isLoading = true

                axios.delete(`/api/datatable/delivery_travel_times/${record}`).then(()=>{
                    this.isLoading = false
                    this.selected= [],
                    this.selected_dropdown_active = false,
                    this.getRecords()
                })
                
            },
            
        },

        mounted() {
            this.getRecords()
        },
    
}

</script>

<style  lang="scss">
    .sortable {
        cursor: pointer;
    }

    .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: .6;

        &--asc {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid #222;

        }

         &--desc {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #222;

        }
    }

  

</style>