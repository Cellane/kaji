import Vue from "vue"
import Vuex from "vuex"
import createPersistedState from "vuex-persistedstate"

Vue.use(Vuex)

const login = {
    state: {
        inProgress: false,
        error: false,
        token: null,
        user: null
    },

    mutations: {
        loginInProgress: state => {
            state.inProgress = true
            state.error = false
        },

        loginFailed: state => {
            state.error = true
        },

        loginSucceeded: (state, { token, user }) => {
            state.error = false
            state.token = token
            state.user = user
        },

        loginFinished: state => {
            state.inProgress = false
        },

        logout: state => {
            state.token = null
            state.user = null
        }
    },

    actions: {
        login: async ({ commit }, payload) => {
            commit("loginInProgress")

            await axios
                .post("/api/session", payload)
                .then(({ data }) => {
                    Vue.notify({
                        type: "success",
                        title: "Logged in!"
                    })
                    commit("loginSucceeded", {
                        token: data.token,
                        user: data.user
                    })
                })
                .catch(error => {
                    Vue.notify({
                        type: "error",
                        title: "Login failed",
                        text:
                            "Unable to log you in. Please check your e-mail address and password."
                    })
                    commit("loginFailed")

                    throw error
                })
                .finally(() => commit("loginFinished"))
        },

        logout: ({ commit }) => {
            Vue.notify({
                type: "success",
                title: "Logged out! Please come back again!"
            })

            commit("logout")
        }
    },

    getters: {
        loggedIn: state => {
            return state.token !== null
        }
    },

    namespaced: true
}

const todayTasks = {
    state: {
        loading: false,
        completing: [],
        error: false,
        notCompleted: [],
        completed: []
    },

    mutations: {
        todayTasksInProgress: state => {
            state.loading = true
            state.error = false
        },

        todayTasksSucceeded: (state, payload) => {
            state.notCompleted = payload.not_completed || []
            state.completed = payload.completed || []
            state.completing = []
        },

        todayTasksFailed: state => {
            state.error = true
        },

        todayTasksFinished: state => {
            state.loading = false
        },

        todayTasksCompleteInProgress: (state, payload) => {
            state.completing.push(payload)
        },

        todayTasksCompleteSucceeded: (state, { id, username }) => {
            const task = state.notCompleted.find(task => task.id === id)

            state.notCompleted = state.notCompleted.filter(
                task => task.id !== id
            )
            state.completed.push({
                ...task,
                completed_today: true,
                completed_today_by: username
            })
        },

        todayTasksCompleteFinished: (state, payload) => {
            state.completing = state.completing.filter(id => id !== payload)
        }
    },

    actions: {
        fetch: async ({ commit }) => {
            commit("todayTasksInProgress")

            await axios
                .get("/api/task?today")
                .then(({ data }) => {
                    commit("todayTasksSucceeded", data)
                })
                .catch(error => {
                    commit("todayTasksFailed")
                    throw error
                })
                .finally(() => commit("todayTasksFinished"))
        },

        complete: async ({ commit, rootState }, payload) => {
            commit("todayTasksCompleteInProgress", payload)

            const username = rootState.login.user.name

            await axios
                .post("/api/completion", { task_id: payload })
                .then(() => {
                    Vue.notify({
                        type: "success",
                        title: "Task completed! 🎉",
                        text: "Good job, you!"
                    })
                    commit("todayTasksCompleteSucceeded", {
                        id: payload,
                        username
                    })
                })
                .finally(() => commit("todayTasksCompleteFinished", payload))
        }
    },

    getters: {
        isCompleting: state => taskId => {
            return state.completing.find(id => id === taskId)
        }
    },

    namespaced: true
}

export default new Vuex.Store({
    modules: {
        login,
        todayTasks
    },
    plugins: [createPersistedState()]
})
