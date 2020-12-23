const template = `
    <div ng-class="{'input-group date':!disabled}">
        <input 
            type="text" 
            name="{{name}}" 
            class="form-control input-sm"
            uib-datepicker-popup 
            is-open="isOpen"
            ng-class="className"
            ng-click="isOpen = !isOpen"
            ng-model="model"
            ng-change="_onChange()"
            ng-required="required"
    
            ng-disabled="disabled"
            on-open-focus="false"
            datepicker-options="{startingDay:1}"
            alt-input-formats="['ddMM','ddMMyy', 'ddMMyyyy']"
            autocomplete="off"
        />
        <span ng-if="!disabled" class="input-group-addon" ng-click="isOpen = !isOpen">
            <i class="fa fa-calendar"></i>
        </span>
    </div>
`;

/*@ngInject*/
module.exports = function () {
    return {
        scope: {
            model: '=ngModel',
            required: '=ngRequired',
            disabled: '=ngDisabled',
            className: '=ngClass',
            name: '@'
        },
        restrict: 'E',
        replace: true,
        template,
        require: 'ngModel',
        link(scope, element, attrs, ngModelCtrl) {
            scope._onChange = () => {
                ngModelCtrl.$setViewValue(scope.model);
            };

            element.find('input').on('change', e => {
                if (scope.isOpen) {
                    scope.$evalAsync(() => scope.isOpen = false);
                }

                if (!ngModelCtrl.$modelValue) {
                    return;
                }

                const _input = e.currentTarget;
                if (/^\d{6,8}$/.test(_input.value)) {
                    const momentDate = moment(ngModelCtrl.$modelValue);
                    if (momentDate.isValid()) {
                        _input.value = momentDate.format('YYYY-MM-DD');
                    }
                }
            })
        },
    }
};
