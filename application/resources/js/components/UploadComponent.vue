<template>
  <v-row>
    <v-col cols="12" v-if="!uploading">
      <v-row v-if="!results">
        <v-col cols="12">
          To start processing, please, select a file
        </v-col>
        <v-col cols="12">
          <v-file-input
              v-model="values.file"
              accept="text/csv"
              color="deep-purple accent-4"
              label="CSV File"
              placeholder="Select your files"
              outlined
          >
          </v-file-input>
        </v-col>
        <v-col cols="12" class="d-flex justify-center">
          or
        </v-col>
        <v-col cols="12">
          <v-textarea
              outlined
              no-resize
              :placeholder="placeholders.textareaValues"
              name="input-7-4"
              label="RAW CSV Input"
              ref="raw"
              v-model="values.raw"
          ></v-textarea>
        </v-col>
        <v-col cols="12">
          <sup class="red-text mr-1">*</sup><span v-text="hints.priority"></span>
        </v-col>
        <v-col class="d-flex justify-center">
          <v-btn block @click="upload">
            Upload
          </v-btn>
        </v-col>
      </v-row>
      <v-row v-else>
        <v-col cols="12">
          <v-data-table
              dense
              :headers="table.headers"
              :items="table.items"
              item-key="item"
              multi-sort
              class="elevation-1"
          ></v-data-table>
        </v-col>
        <v-col cols="6" class="d-flex justify-center">
          <v-btn block @click="downloadCsv">
            Download CSV
          </v-btn>
        </v-col>
        <v-col cols="6" class="d-flex justify-center">
          <v-btn block @click="reset">
            Reset
          </v-btn>
        </v-col>
      </v-row>
    </v-col>
    <v-col cols="12" v-else>
      <v-progress-linear
          indeterminate
          color="teal"
      ></v-progress-linear>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "UploadComponent",
  data() {
    return {
      uploading: false,
      placeholders: {
        textareaValues: "Example\r\n" +
            "Item 1,25,6\r\n" +
            "Item 2,22,4\r\n" +
            "Item 3,10,6.5"
      },
      values: {
        file: null,
        raw: null,
      },
      hints: {
        priority: "If You have selected a File and set the RAW input - File will be prioritized over"
      },
      results: false,
      table: {
        headers: [],
        items: []
      },
      downloadable: [],
    }
  },
  methods: {
    reset() {
      this.results = false;
      this.downloadable = [];
      this.table = {
        headers: [],
        items: []
      };
      this.values = {
        file: null,
        raw: null,
      };
    },
    downloadCsv() {
      let link = document.createElement('a');

      link.setAttribute('download', 'processed.csv');
      link.setAttribute('href', ['data:text/csv;charset=utf-8', encodeURIComponent(this.downloadable.join("\r\n"))].join(','));

      link.click();
    },
    processData(data) {
      let _vm = this;

      _vm.table.headers = [
        {text: 'Item', value: 'item', sortable: true, align: 'start'},
        {text: 'Total', value: 'total', sortable: true}
      ];

      Object.keys(data)
          .forEach(function (item) {
            let object = data[item];

            _vm.downloadable.push([item, object['total']].join(','));

            _vm.table.items.push({
              item,
              total: object['total']
            })
          })
    },
    async validate() {
      let data = null,
          isFile = false,
          options = {};

      if (this.values.file) {
        isFile = true;
        options = {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        };
        data = new FormData();
        data.append('csv', this.values.file);
      }

      if (this.values.raw) {
        data = {
          csv: this.values.raw.replace(/\r?\n/g, "\n")
        };
      }

      return {
        data,
        valid: isFile ? true : this.validateContent(data['csv']),
        options
      };
    },
    validateContent(content) {
      let invalidLines = 0;

      content.split("\n")
          .forEach((line, i) => {
            let l = line.split(',');

            if (l.length !== 3) {
              console.log('Invalid line', i, l)
            }

            invalidLines += line.split(',').length !== 3 ? 1 : 0
          })

      return invalidLines === 0;
    },
    async upload() {
      let validation = await this.validate();

      this.$http.post('/upload', validation.data, validation.options)
          .then(response => {
            this.processData(response.data.data);
            this.results = true;

            this.values.file = null;
            this.values.raw = null;
            this.uploading = false;
          })
          .catch(e => {
            this.uploading = false;
            console.log('Error', e);
          });
    }
  },
}
</script>

<style scoped>

</style>