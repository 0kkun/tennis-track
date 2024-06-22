module.exports = QueryParamSnakeCase;

function QueryParamSnakeCase() {
  return {
    Parameter: {
      enter(parameter, ctx) {
        if (parameter.in === 'query') {
          // $refの解決
          if ('$ref' in parameter) {
            const resolved = ctx.resolve(parameter.$ref);
            if (resolved.result) {
              parameter = resolved.result;
            }
          }

          // スネークケースの正規表現
          const snakeCaseRegex = /^[a-z0-9]+(?:_[a-z0-9]+)*$/;

          // パラメータ名のチェック
          if (!snakeCaseRegex.test(parameter.name)) {
            ctx.report({
              message: `The query parameter "${parameter.name}" must be a snake case.`,
              location: ctx.location.child('name'),
            });
          }
        }
      },
    },
  };
}
