<template>
  <div id="unit" class="p-6"> 
        <div class="min-w-screen min-h-screen bg-gray-100 flex justify-center rounded-lg shadow-md">
            <loading v-model:active="isLoading"
                 :can-cancel="true"
                 :is-full-page="fullPage"/>
            <div class="w-full p-1">
            <div class="flex justify-between pt-4">
                <div class="text-2xl font-semibold uppercase"> Table {{response.table}}</div>
                <div>
                    <a href="#" 
                    class="p-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                    v-if="(isFirstLevelUser || isSecondLevelUser || isThirdLevelUser) && response.allow.creation"
                    @click.prevent="creating.active = !creating.active">
                    {{ creating.active ? 'Hide' : 'New record' }}
                    </a>
                </div>               
            </div>
            <!-- New Record section  -->
            <div class="flex justify-center" v-if="response.allow.creation && creating.active">
                <div class="w-1/8 rounded-lg">
                <h3 class="text-xl text-gray text-center font-bold  p-3 mb-1">New {{response.table}}</h3>
                    <form action="#" @submit.prevent="store">
                        <!-- @csrf -->
                        <div class="mb-2" v-for="column in response.updatable" :key="column" >
                            <label :for="column" class="sr-only"> </label>
                            <input type="text" :name="column" :id="column" :placeholder="column" class="bg-gray-100 border-2 w-full p-1 rounded-lg"
                            :class="{ 'border-red-500': creating.errors[column] }"
                            v-model="creating.form[column]">
                            <div class="text-red-500 mt-2 text-sm" v-if="creating.errors[column]">
                                    <strong>{{ creating.errors[column][0] }}</strong>
                            </div>
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
                    {{ column }}
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
                        <option value="150">200</option>
                        <option value="">All</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-1 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
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
     
        <!-- start Table -->
        
            <div  v-if="filteredRecords.length" class="bg-white shadow-md rounded my-3  overflow-x-auto">
                <table class="min-w-max w-full table-auto">
                <!-- Table Heading Section -->
                    <thead class="py-2">
                        <tr class="py-2 bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-2" v-if="canSelectItems">
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
                                    <th class="text-left"
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
                                class="text-left" 
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
                            <th class="text-left">Actions </th>                          
                        </tr>
                    </thead>
                    <!-- End Table Heading -->
                     <!-- Row (Records) Section -->                    
                    <tbody class="text-gray-600 text-sm font-light">
                        <!-- Loop Through each records getting from controller -->
                        <tr v-for="record in filteredRecords" :key="record"  class="border-b border-gray-200 bg-gray-50 hover:bg-gray-100">                          
                            <td v-if="canSelectItems" class=" text-center">
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
                                       
                                    <template v-if="column=='type'">
                                        <td class="py-2 text-left"  
                                            :class="{ 'text-center': textCenterColumns.includes(column)}" 
                                            v-if="response.displayable.includes(column)"
                                        > 
                                            <select :name="column" :id="column" v-model="editing.form[column]"
                                                class="rounded-r rounded-l sm:rounded-l-none border border-gray-400 pl-1 pr-1 py-1 bg-white text-sm text-gray-700 focus:bg-white"                                            
                                            >
                                                <option  value="GM">GM</option>
                                                <option  value="I">I</option>
                                                <option  value="All">All</option>                             
                                            </select>

                                            <div class="text-red-500 mt-2 text-sm" v-if="editing.errors[column]">
                                                    <strong>{{ editing.errors[column][0] }}</strong>
                                            </div>
                                        </td>
                                    </template>   

                                    <template v-else>
                                        <td class="py-2 text-left"  
                                        :class="{ 'text-center': textCenterColumns.includes(column)}" 
                                        v-if="response.displayable.includes(column)"> 
                                            <input type="text"  
                                            class="rounded-r rounded-l sm:rounded-l-none border border-gray-400 pl-1 pr-1 py-1 bg-white text-sm text-gray-700 focus:bg-white"
                                            v-model="editing.form[column]"
                                            :class="{ 'border-3 border-red-700': editing.errors[column] }"
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

                                <template v-else-if="column=='causer_id'">
                                        <div class="flex items-center">
                                        <span class="font-medium" >
                                        {{response.userOptions[columnValue]}}
                                        </span>
                                    </div>
                                </template>
                                
                                 <template v-else>
                                    <td class="py-2 text-left"  
                                    :class="{ 'text-center': textCenterColumns.includes(column) }"
                                    v-if="response.displayable.includes(column)"> 
                                         <div class="flex items-center">
                                            <span class="font-medium" >{{columnValue}}</span>
                                        </div>    
                                    </td>
                                </template>
                            </template> <!-- End Not in Edit Mode -->                               
                               
                        </template> <!-- end Loop through each column of rows-->

                         <!-- Last Column - Actions -->  
                            
                             <td>
                            <div>
                                <a href="#" @click.prevent="edit(record)"  v-if="editing.id !== record.id"
                                class=" mr-1 py-1 px-3 shadow-md rounded-full bg-yellow-500 text-white text-sm hover:bg-yellow-700 focus:outline-none"
                                >
                                Edit
                                </a>   
                                 <a href="#" 
                                @click.prevent="destroy(record.id)" 
                                v-if="response.allow.deletion && editing.id !== record.id 
                                && (isFirstLevelUser || isSecondLevelUser) && canSelectItems" 
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
export default {
  middleware: [
        //   redirectIfNotCustomer
      ],

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
                
                
                selected: [],


                isLoading: false,
                fullPage: true,

                  // Hide Column Section : checkbox of columns that completely disappear
                unshownColumns:['slug','img'],

                // columns hidden - can be show by unclick the radio buttons
                hideColumns:['parent_id', 'slug'],
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
                
                textCenterColumns:[],
                dollarsSymbolColumns:[],
                
                limit:50,
                quickSearchQuery: '',

                selected_dropdown_active: false,
                
               
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
            getRoleNames(){
                const rolNameArray = []
                if (this.response.userRoleOptions){
                    const allRoleNames = this.response.userRoleOptions
                    allRoleNames.forEach(element => {
                    rolNameArray.push(element.name)
                });                }
                
              
                return rolNameArray;

            },
            columnsNotAllowToShowAccordingToUserLevel(){
                if(this.isFirstLevelUser) {
                    return [] ;
                } else if (this.isSecondLevelUser){
                    return this.secondLevel_ColumnNotAllowsToShow;
                } 
                else if (this.isThirdLevelUser){
                    return this.thirdLevel_ColumnNotAllowsToShow ;
                } 
                else if (this.isFourthLevelUser){
                    return this.fourthLevel_ColumnNotAllowsToShow ;
                } 
                return this.fourthLevel_ColumnNotAllowsToShow;
            },

            columnsNotAllowToEditAccordingToUserLevel(){
                if(this.isFirstLevelUser) {
                    return [] ;
                } else if (this.isSecondLevelUser){
                    return this.secondLevel_ColumnNotAllowsToEdit;
                } 
                else if (this.isThirdLevelUser){
                    return this.thirdLevel_ColumnNotAllowsToEdit ;
                } 
                else if (this.isFourthLevelUser){
                    return this.fourthLevel_ColumnNotAllowsToEdit ;
                } 
                return this.fourthLevel_ColumnNotAllowsToEdit;
            },

            columnsNotAllowToShowAccordingToUserLevel(){
                if(this.isFirstLevelUser) {
                    return [] ;
                } else if (this.isSecondLevelUser){
                    return this.secondLevel_ColumnNotAllowsToShow;
                } 
                else if (this.isThirdLevelUser){
                    return this.thirdLevel_ColumnNotAllowsToShow;
                } 
                else if (this.isFourthLevelUser){
                    return this.fourthLevel_ColumnNotAllowsToShow;
                } 
                return this.fourthLevel_ColumnNotAllowsToShow;
            },

            isFirstLevelUser() {
                let isCorrect = false;
                for (var i = 0; i < this.firstLevelUsers.length; i++) {
                    if (this.getRoleNames.includes(this.firstLevelUsers[i])) 
                    {
                        isCorrect = true;
                        break;
                    }
                }
                return isCorrect;
            },
            isSecondLevelUser() {
                let isCorrect = false;
                for (var i = 0; i < this.secondLevelUsers.length; i++) {
                    if (this.getRoleNames.includes(this.secondLevelUsers[i])) 
                    {
                        isCorrect = true;
                        break;
                    }
                }
                return isCorrect;
            },
            isThirdLevelUser() {
                let isCorrect = false;
                for (var i = 0; i < this.thirdLevelUsers.length; i++) {
                    if (this.getRoleNames.includes(this.thirdLevelUsers[i])) 
                    {
                        isCorrect = true;
                        break;
                    }
                }
                return isCorrect;
            },
            isFourthLevelUser() {
                let isCorrect = false;
                for (var i = 0; i < this.fourthLevelUsers.length; i++) {
                    if (this.getRoleNames.includes(this.fourthLevelUsers[i])) 
                    {
                        isCorrect = true;
                        break;
                    }
                }
                return isCorrect;
            },
  },

   methods: {
            showHideColumn(){
                alert('hi');
            },
            
            getRecords(){

                return axios.get(`/api/datatable/activity_logs?${this.getQueryParameters()}`).then((response)=> {
                    this.response = response.data.data;
                    
                })
            },
            getQueryParameters () {
                return queryString.stringify({
                    limit: this.limit,
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
                axios.patch(`/api/datatable/activity_logs/${this.editing.id}`, this.editing.form).then((response) => {
                    this.getRecords().then(() => {
                        this.editing.id = null
                        this.editing.form = null
                      
                    })
                }).catch((error) => {
                    if (error.response.status === 422) {                        
                        this.editing.errors = error.response.data.errors
                    }
                })
            },
            store () {    
                axios.post(`/api/datatable/activity_logs`, this.creating.form).then((response) => {
                    this.getRecords().then(() => {
                        this.creating.active = true
                        this.creating.form = {}
                        this.creating.errors = []
                    })
                }).catch((error) => {
                    if (error.response.status === 422) {
                        this.creating.errors = error.response.data.errors
                        
                    }
                })
            },
               
            destroy(record){

                if(!window.confirm(`Are you sure?`)){
                    return
                }

                axios.delete(`/api/datatable/activity_logs/${record}`).then(()=>{
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