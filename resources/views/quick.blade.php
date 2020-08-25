@extends('layout')

@section('title')
    Quick Generators
@endsection

@section('subtitle')
    Uncomplicated, quick generators for small things
@endsection

@section('content')
    <p>The following are small generators that you run from this page. These are not saved to your creations.</p>

    <h2><img class="art-icon" src="{{ asset('img/art-icons/alcoholic_drink.png') }}"> Alcoholic Drink Generator</h2>
    <p>This generates a unique alcoholic drink.</p>
    <p><button v-on:click="generateDrink">Generate New Drink</button></p>
    <blockquote>@{{ drinkDescription }}</blockquote>

    <h2><img class="art-icon" src="{{ asset('img/art-icons/chop_shop.png') }}"> Cyberpunk Chop Shop Generator</h2>
    <p>Part of the <a href="https://reddit.com/r/rpg_generators">r/rpg_generators</a> subreddit <a href="https://www.reddit.com/r/rpg_generators/comments/ftnsx4/cyberpunk_for_april_rpg_generators_challenge/">Cyberpunk Challenge</a> for April 2020. This generates a cyberpunk chop shop.</p>
    <p><button v-on:click="generateChopShop">Generate New Chop Shop</button></p>
    <blockquote>@{{ chopShopDescription }}</blockquote>

    <h2><img class="art-icon" src="{{ asset('img/art-icons/language.png') }}"> Language Generator</h2>
    <p>This generates a description of a fantasy language for you.</p>
    <p><button v-on:click="generateLanguage">Generate New Language</button></p>
    <blockquote>@{{ languageDescription }}</blockquote>

    <h2><img class="art-icon" src="{{ asset('img/art-icons/organization.png') }}"> Organization Generator</h2>
    <p>This generates a fantasy organization.</p>
    <p><button v-on:click="generateOrganization">Generate New Organization</button></p>
    <blockquote>@{{ organizationDescription }}</blockquote>

    <h2><img class="art-icon" src="{{ asset('img/art-icons/town_medium.png') }}"> Town Generator</h2>
    <p>Need a quick town? Click here.</p>
    <p><button v-on:click="generateTown">Generate New Town</button></p>
    <blockquote>@{{ townDescription }}</blockquote>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.min.js"></script>
@endsection

@section('javascript')
function getRandomInt(max) {
    return Math.floor(Math.random() * Math.floor(max))
}

function getRandomItem(items) {
    var item = items[Math.floor(Math.random()*items.length)]

    return item
}

function getCSFront() {
    choices = [
        "Outside, a large neon sign proclaims the name of the shop, the brightness of the writing diffused by thick smog.",
        "A vagrant slumps against the wall next to the door of the shop. He clutches a brown paper bag in his good hand, the other hand a wreckage of cybernetics that no longer appear functional.",
        "The shop's dark exterior walls are offset by neon lights bordering the doorway, giving it the appearance of a portal into another world."
    ]

    return getRandomItem(choices)
}

function getCSEntry() {
    choices = [
        "As you go inside, you notice a handful of locals watch you with hard eyes, then turn away.",
        "You open the door to the shop, and a soft chime announces your entry.",
        "Entry to the shop sets off a soft chime to alert the staff."
    ]

    return getRandomItem(choices)
}

function getCSProductDisplays() {
    choices = [
        "The shop's wares are displayed on large screens placed throughout the front room.",
        "A handful of model cybernetics lay strewn haphazardly on shelves in the front room. Beside the shelves are a couple old displays, their screens flickering and dull.",
        "Each of the shop's offerings is shown on a screen that takes up an entire wall.",
        "A couple attendants in bright uniforms greet customers and answer questions about the shop's offerings."
    ]

    return getRandomItem(choices)
}

function getCSCustomers() {
    choices = [
        "A few customers silently shuffle through the displays or wait in the small lobby for patients.",
        "One or two people wait in the back for their turn under the knife.",
        "Several people are standing in front of the display screens, flipping curiously through the options. The chairs and benches in the patient lobby are all full."
    ]

    return getRandomItem(choices)
}

function getCSBack() {
    choices = [
        "The operating room is bright and clean. Two technicians in immaculate uniforms assist the cyberdoc.",
        "In the back, a single operating table sits in the center of the room surrounded by harsh white lights.",
        "In the back, the sole cyberdoc of the shop stands over an operating table. Tools of various types and sizes sit on shelves nearby.",
    ]

    return getRandomItem(choices)
}

var app = new Vue({
    el: '#app',
    data: {
        chopShopDescription: '',
        drinkDescription: '',
        languageDescription: '',
        languageName: '',
        organizationDescription: '',
        townDescription: ''
    },
    methods: {
        generateChopShop: function (event) {
            description = getCSFront() + " " + getCSEntry() + " " + getCSProductDisplays() + " " + getCSCustomers() + " " + getCSBack()
            this.chopShopDescription = description
        },
        generateDrink: function (event) {
            this.drinkDescription = 'Generating...'

            url = '{{ route('api.alcoholic_drink.random') }}'

            fetch(url)
            .then(response => response.json())
            .then(response => {
            this.drinkDescription = response.alcoholic_drink.description
            })
            .catch(error => console.error(error));
        },
        generateLanguage: function (event) {
            this.languageDescription = 'Generating...'

            url = '{{ route('api.language.random') }}'

            fetch(url)
            .then(response => response.json())
            .then(response => {
                this.languageDescription = response.language.description
            })
            .catch(error => console.error(error));
        },
        generateOrganization: function (event) {
            this.organizationDescription = 'Generating...'

            url = '{{ route('api.organization.random') }}'

            fetch(url)
            .then(response => response.json())
            .then(response => {
                this.organizationDescription = response.organization.description
            })
            .catch(error => console.error(error));
        },
        generateTown: function (event) {
            this.townDescription = 'Generating...'

            url = '{{ route('api.town.random') }}'

            fetch(url)
            .then(response => response.json())
            .then(response => {
                this.townDescription = response.town.description
            })
            .catch(error => console.error(error));
        }
    }
})

app.generateChopShop()
app.generateDrink()
app.generateLanguage()
app.generateOrganization()
app.generateTown()
@endsection
