import { api } from '../../../boot/axios.js'

export class QueryBuilder {
  constructor(url) {
    this._url = url
    this.reset()
  }

  /**
   * Set the url value
   *
   * @param {*} url The url value
   * @returns
   */
  url(url) {
    this._url = url
    return this
  }

  /**
   *
   * @param  {...any} args The arguments to be passed to the include method
   * @returns  {QueryBuilder} The QueryBuilder instance
   */
  include(...args) {
    args.forEach((arg) => {
      if (typeof arg === 'string') {
        this._includes.push(arg)
      } else if (Array.isArray(arg)) {
        this.include(...arg)
      } else {
        throw new Error('Invalid argument type')
      }
    })

    return this
  }

  /**
   * Append the given value to the appends array
   *
   * @param  {...any} args The arguments to be passed to the append method
   *
   * @returns  {QueryBuilder} The QueryBuilder instance
   */
  append(...args) {
    args.forEach((arg) => {
      switch (typeof arg) {
        case 'array':
          this.append(...arg)
          break
        case 'string':
          this._appends.push(arg)
          break
        default:
          throw new Error()
      }
    })
    return this
  }

  /**
   * @param  {...any} args The arguments to be passed to the field method
   * @returns  {QueryBuilder} The QueryBuilder instance
   */
  fields(...args) {
    switch (args.length) {
      case 1:
        if (typeof args[0] !== 'object') {
          throw new Error('Invalid argument type')
        }
        Object.entries(args[0]).forEach((entry) => {
          this.fields(...entry)
        })
        break
      case 2:
        if (typeof args[0] !== 'string' || !Array.isArray(args[1])) {
          throw new Error()
        }
        this._fields[args[0]] = args[1]
        break
      default:
        throw new Error()
    }

    return this
  }

  /**
   * Set the page number
   * @param {*} page The page number
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  page(page) {
    if (typeof page !== 'number' && typeof page !== 'string') {
      throw new Error()
    }
    this._page = page
    return this
  }

  /**
   * Set the limit number
   * @param {*} page The limit number
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  limit(limit) {
    if (typeof limit !== 'number' && typeof limit !== 'string') {
      throw new Error()
    }
    this._limit = limit
    return this
  }

  /**
   * Set the filter value
   * @param args The arguments to be passed to the filter method
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  filter(...args) {
    switch (args.length) {
      case 1:
        if (typeof args[0] !== 'object') {
          throw new Error('Object argument expected')
        }
        Object.entries(args[0]).forEach((entry) => {
          this.filter(...entry)
        })
        break
      case 2:
        if (args[1] === null) {
          delete this._filters[args[0]]
          break
        }

        if (
          typeof args[0] !== 'string' ||
          (['string', 'number', 'boolean'].indexOf(typeof args[1]) === -1 &&
            !Array.isArray(args[1]))
        ) {
          throw new Error('Argument type mismatch')
        }
        this._filters[args[0]] = args[1]
        break
      default:
        throw new Error('Invalid argument type')
    }
    return this
  }

  /**
   * Set the sort value
   * @param args The arguments to be passed to the sort method
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  sort(...args) {
    args.forEach((arg) => {
      switch (typeof arg) {
        case 'array':
          this.sort(...arg)
          break
        case 'string':
          // Check if the field is already in the sorts array
          if (this._sorts.indexOf(arg.replace(/^-/, '')) !== -1) {
            // If the field is already in the sorts array, remove it
            this._sorts.splice(this._sorts.indexOf(arg.replace(/^-/, '')), 1)
          }

          this._sorts.push(arg)

          break
        default:
          throw new Error()
      }
    })
    return this
  }

  /**
   * Tap the QueryBuilder instance to execute the callback
   * @param {*} callback
   * @returns
   */
  tap(callback) {
    if (typeof callback !== 'function') {
      throw new Error()
    }
    callback(this)
    return this
  }

  /**
   * Conditionally execute the callback if the condition is true
   * @param {*} condition
   * @param {*} callback
   * @param {*} defaultCallback
   * @returns
   */
  when(condition, callback, defaultCallback = null) {
    if (typeof callback !== 'function') {
      throw new Error('Callback must be a function')
    }
    condition = typeof condition === 'function' ? condition() : condition
    if (condition) {
      callback(this)
    } else {
      if (defaultCallback) {
        defaultCallback(this)
      }
    }
    return this
  }

  /**
   * Build the query string
   * @param {boolean} encode Whether to encode the string or not
   *
   * @returns {string} The query string
   */
  build(encode = true) {
    const encoder = encode ? encodeURIComponent : (value) => value

    const params = []

    Object.entries(this._filters).forEach((entry) => {
      params.push({ [`filter[${[encoder(entry[0])]}]`]: encoder(entry[1]) })
    })

    this._sorts.length && params.push({ sort: this._sorts.map(encoder).join(',') })

    this._includes.length && params.push({ include: this._includes.map(encoder).join(',') })

    this._appends.length && params.push({ append: this._appends.map(encoder).join(',') })

    Object.entries(this._fields).forEach((entry) => {
      params.push({ [`fields[${encoder(entry[0])}]`]: entry[1].map(encoder).join(',') })
    })

    if (this._page) {
      params.push({ page: encoder(this._page) })
    }

    if (this._limit) {
      params.push({ per_page: encoder(this._limit) })
    }

    Object.entries(this._params).forEach((entry) => {
      params.push({ [encoder(entry[0])]: encoder(entry[1]) })
    })

    return Object.assign({}, ...params)
  }

  /**
   * Add a custom parameter to the query string
   * @param {*} key
   * @param {*} value
   * @returns
   */
  param(key, value) {
    if (typeof key !== 'string') {
      throw new Error()
    }

    this._params[key] = value
    return this
  }

  /**
   * Forget the sort value
   *
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  forgetSort() {
    this._sorts = []
    return this
  }

  /**
   * Forget the param
   *
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  forgetParam(key) {
    delete this._params[key]
    return this
  }

  /**
   * Forget the filter value
   *
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  forgetFilter() {
    this._filters = {}
    return this
  }

  /**
   * Forget the include value
   *
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  forgetInclude() {
    this._includes = []
    return this
  }

  /**
   * Forget the append value
   *
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  forgetAppend() {
    this._appends = []
    return this
  }

  /**
   * Reset the QueryBuilder instance
   *
   * @returns {QueryBuilder} The QueryBuilder instance
   */
  reset() {
    this._filters = {}
    this._sorts = []
    this._page = null
    this._limit = null
    this._fields = []
    this._includes = []
    this._appends = []
    this._params = {}

    return this
  }

  /**
   * Get the query string
   * @returns {string} The query string
   */
  toString() {
    const params = this.build()

    const queryString = Object.entries(params)
      .map((entry) => {
        return `${entry[0]}=${entry[1]}`
      })
      .join('&')

    return `${this._url}?${queryString}`
  }

  static fromString(url) {
    const [resource, query] = url.split('?')

    const params = query.split('&')

    const builder = new QueryBuilder(resource)

    params.forEach((param) => {
      if (!param) return

      const [key, value] = param.split('=')

      const values = value.split(',')

      if (key === 'sort') {
        builder.sort(...values)
      } else if (key === 'include') {
        builder.include(...values)
      } else if (key === 'append') {
        builder.append(...values)
      } else if (key === 'page') {
        builder.page(+value)
      } else if (key === 'per_page') {
        builder.limit(+value)
      } else if (key.startsWith('filter')) {
        const filter = key.replace('filter[', '').replace(']', '')
        builder.filter(filter, values)
      } else if (key.startsWith('fields')) {
        const field = key.replace('fields[', '').replace(']', '')
        builder.fields(field, values)
      } else {
        builder.param(key, value)
      }
    })

    return builder
  }

  /**
   * Execute the query and return the response
   *
   * @returns {Promise} The response
   */
  async get() {
    return await api.get(this.toString())
  }
}
