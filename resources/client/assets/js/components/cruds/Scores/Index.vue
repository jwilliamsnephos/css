<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Scores</h1>
        </section>

        <section class="content">
            <div class="row no-print">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Search</h3><br />
                            <span>Filter the scores by the following values</span>
                        </div>

                        <div class="box-body">

                            <div class="form-group">
                                <label for="event">Event</label>
                                <v-select
                                    name="event"
                                    label="name"
                                    @input="updateEvent"
                                    :value="event"
                                    :options="eventsAll" />
                            </div>

                            <div class="form-group">
                                <label for="team">Team</label>
                                <v-select
                                    name="team"
                                    label="name"
                                    @input="updateTeam"
                                    :value="team"
                                    :options="teamsAll" />
                            </div>

                            <div class="form-group">
                                <label for="participant">Participant</label>
                                <v-select
                                    name="participant"
                                    label="name"
                                    @input="updateParticipant"
                                    :value="participant"
                                    :options="participantsAll" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">List</h3>
                        </div>

                        <div class="box-body">
                            <div class="btn-group">
                                <router-link
                                        v-if="$can(xprops.permission_prefix + 'create')"
                                        :to="{ name: xprops.route + '.create' }"
                                        class="btn btn-success btn-sm"
                                        >
                                    <i class="fa fa-plus"></i> Add new
                                </router-link>

                                <button type="button" class="btn btn-default btn-sm" @click="refresh">
                                    <i class="fa fa-refresh" :class="{'fa-spin': loading}"></i> Refresh
                                </button>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="row" v-if="loading">
                                <div class="col-xs-4 col-xs-offset-4">
                                    <div class="alert text-center">
                                        <i class="fa fa-spin fa-refresh"></i> Loading
                                    </div>
                                </div>
                            </div>

                            <datatable
                                    v-if="!loading"
                                    :columns="columns"
                                    :data="data"
                                    :total="total"
                                    :query="query"
                                    :xprops="xprops"
                                    />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'
import DatatableActions from '../../dtmodules/DatatableActions'
import DatatableSingle from '../../dtmodules/DatatableSingle'
import DatatableList from '../../dtmodules/DatatableList'
import DatatableCheckbox from '../../dtmodules/DatatableCheckbox'


export default {
    data() {
        return {
            columns: [
                { title: '#', field: 'id', sortable: true, colStyle: 'width: 50px;', visible: false },
                { title: 'Event', field: 'event', tdComp: DatatableSingle },
                { title: 'Team', field: 'team', tdComp: DatatableSingle },
                { title: 'Participant', field: 'participant', tdComp: DatatableSingle },
                { title: 'Score', field: 'score', sortable: true },
                { title: 'Xcount', field: 'xcount', sortable: true },
                { title: 'Actions', tdComp: DatatableActions, visible: true, thClass: 'text-right', tdClass: 'text-right', colStyle: 'width: 130px;' }
            ],
            query: { sort: 'id', order: 'desc' },
            xprops: {
                module: 'ScoresIndex',
                route: 'scores',
                permission_prefix: 'score_'
            }
        }
    },
    created() {
        this.$root.relationships = this.relationships;
        this.fetchData();
        this.fetchEventsAll();
        this.fetchTeamsAll();
        this.fetchParticipantsAll();
    },
    destroyed() {
        this.resetState()
    },
    computed: {
        ...mapGetters('ScoresIndex', ['data', 'total', 'loading', 'relationships', 'event', 'team', 'participant', 'eventsAll', 'teamsAll', 'participantsAll']),
    },
    watch: {
        query: {
            handler(query) {
                this.setQuery(query)
            },
            deep: true
        }
    },
    methods: {
        ...mapActions('ScoresIndex', ['fetchData', 'setQuery', 'resetState', 'setEvent', 'setTeam', 'setParticipant', 'fetchEventsAll', 'fetchTeamsAll', 'fetchParticipantsAll']),
        updateEvent(value) {
            this.setEvent(value);
            this.refresh();
        },
        updateTeam(value) {
            this.setTeam(value)
            this.refresh();
        },
        updateParticipant(value) {
            this.setParticipant(value)
            this.refresh();
        },
        refresh: function () {
            let constraints = (this.event || this.team || this.participant) ? {eventId: null, teamId: null, participantId: null} : null;
            if (this.event) {
                constraints.eventId = this.event.id;
            }
            if (this.team) {
                constraints.teamId = this.team.id;
            }
            if (this.participant) {
                constraints.participantId = this.participant.id;
            }
            this.fetchData(constraints);
        }
    }
}
</script>


<style scoped>

</style>
