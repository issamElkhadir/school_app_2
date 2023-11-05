/**
 * Check if the key is set (use dot notation for nested keys)
 * 
 * @param obj The object to check the key from
 * @param key The key to be checked
 */
export function has(obj, key) {
  const items = key.split('.')
  let value = obj

  while (items.length && value) {
    value = value[items.shift()]
  }
  return value
}

/**
 * Get the value of the key if set, or return the defaultValue (use dot notation for nested keys)
 * 
 * @param obj The object to get the key from
 * @param key The key to get the value from (use dot notation for nested keys)
 * @param defaultValue The default value to return if the key is not set
 * @returns {*}
 */
export function get(obj, key, defaultValue = null) {
  if (!has(obj, key)) {
    return defaultValue
  }

  return (
    key.split('.').reduce((obj, key) => {
      return obj[key]
    }, obj) || defaultValue
  )
}

/**
 * Set the value of the key (use dot notation for nested keys)
 * 
 * @param obj The object to check the key from
 * @param key The key to be set (use dot notation for nested keys)
 * @param value The value of the key
 * @param override Override if the key is already exists.
 */
export function set(obj, key, value, override = false) {
  const keys = key.split('.')
  const lastKey = keys.pop()

  obj = keys.reduce((obj, key) => {
    return obj[key]
  }, obj)

  if (override || !obj[lastKey]) {
    obj[lastKey] = value
  }
}

/**
 * Remove the key (use dot notation for nested keys)
 * 
 * @param obj The object to check the key from
 * @param key The key to be removed (use dot notation for nested keys)
 */
export function remove(obj, key) {
  if (!has(obj, key)) {
    return
  }

  const keys = key.split('.')
  const lastKey = keys.pop()
  obj = keys.reduce((obj, key) => {
    return obj[key]
  }, obj)
  delete obj[lastKey]
}
