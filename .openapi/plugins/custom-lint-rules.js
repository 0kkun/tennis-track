const QueryParamSnakeCase = require('./rules/query-param-snake-case')
// const SchemaPropertySnakeCase = require('./rules/schema-property-snake-case')
// const OperationIdCamelCase = require('./rules/operation-id-camel-case')
// const TagsKebabCase = require('./rules/tags-kebab-case')
// const EnumSnakeCase = require('./rules/enum-snake-case')

module.exports = {
  id: 'my-local-plugin',
  rules: {
    oas3: {
      'query-param-snake-case': QueryParamSnakeCase,
      // 'schema-property-snake-case': SchemaPropertySnakeCase,
      // 'operation-id-camel-case' : OperationIdCamelCase,
      // 'tags-kebab-case' : TagsKebabCase,
      // 'enum-snake-case': EnumSnakeCase
    },
  },
}
