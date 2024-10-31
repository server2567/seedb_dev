<!DOCTYPE html>
<html>

<head>
    <title>Organization Structure</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/Treant.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/basic-example.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/Treant.min.js"></script>
    <style>
        .nodeP {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            min-height: 130px;
            width: 400px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nodeD {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            height: auto;
            width: 400px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nodeP img {
            width: 45px;
            height: 50px;
            border-radius: 50%;
        }

        .nodeP .node-name {
            font-weight: bold;
            margin-top: 10px;
        }

        .nodeP .node-title {
            font-size: 0.8em;
            color: gray;
        }

        .department {
            font-weight: bold;
            margin: 10px 0;
            color: #333;
        }

        .tree {
            width: 100%;
            max-height: 840px;
            overflow-y: scroll;
            overflow-x: scroll;
        }

        .Treant .collapse-switch {
            width: 7%;
            height: 7%;
            border: none;
        }
        .Treant .collapse-switch::before {
            content: '\25BC'; /* Down arrow */
            display: inline-block;
            /* transform: rotate(deg); */
            margin-right: 10px;
            font-size: 17px;
            font-weight: bold;
        }

        .Treant .collapsed .collapse-switch::before {
            content: '\25B2'; /* Up arrow */
            margin-right: 10px;
            /* transform: rotate(-90deg); */
        }
        .Treant .node.collapsed {
            background-color: none;
        }

        .Treant .node.collapsed .collapse-switch {
            background: none;
        } 
    </style>
</head>

<body>
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button accordion-button-table" type="button">
                    <i class="bi-server icon-menu"></i><span> โครงสร้างของ<?= $mt_info[0]->dp_name_th ?></span>
                </button>
            </h2>
            <div id="collapseShow" class="accordion-collapse collapse show">
                <div class="card-body">
                    <div class="tree" id="tree-simple"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var data2 = <?= json_encode($mt_info) ?>;
        var personData = <?= json_encode($stdp_info) ?>;
        var base_stuc_po = <?= json_encode($base_structure_position) ?>;
        var position = []
        function createNodeStructure(nodeData) {
            var nodeName = typeof nodeData.stde_name_th !== 'undefined' ? nodeData.stde_name_th : (typeof nodeData.dp_name_th !== 'undefined' ? nodeData.dp_name_th : "");
            var nodeStructure = {
                HTMLclass: nodeData.personnel ? "nodeP" : "nodeD",
                innerHTML: `
            <div>
                <div class="department">${nodeName}</div>
            </div>`
            };

            if (nodeData.img) {
                nodeStructure.innerHTML += `
            <div>
                <img src="${nodeData.img}" width="150px" height="200px">
                <div class="node-name">${nodeData.full_name}</div>
                <div class="node-title">${nodeData.stpo_name ? nodeData.stpo_name : " "}</div>
            </div>`;
            }

            if (nodeData.personnel || nodeData.department) {
                nodeStructure.children = [];

                if (nodeData.personnel) {
                    nodeData.personnel.forEach((person, index) => {
                        nodeStructure.innerHTML += `
                        <div>
                            <img id="profile_picture${person.stdp_id}">
                            <div class="node-name">${person.full_name}</div>
                            <div class="node-title">${person.stpo_name ? person.stpo_name : "-"}</div>
                        </div>`;
                    });
                }
                if (nodeData.department) {
                    let currentNode = nodeStructure;

                    nodeData.department.forEach((dept) => {
                        var deptNode = createNodeStructure(dept);

                        if (dept.stde_level == 4) {
                            if (!currentNode.children) {
                                currentNode.children = [];
                            }
                            currentNode.children.push(deptNode);
                            currentNode = deptNode;
                            currentNode.children = [];
                        } else {
                            if (!nodeStructure.children) {
                                nodeStructure.children = [];
                            }
                            nodeStructure.children.push(deptNode);
                        }
                    });
                }
            }
            return nodeStructure;
        }

        function createTreeData(data) {
            var treeData = {
                chart: {
                    container: "#tree-simple",
                    connectors: {
                        type: 'step'
                    },
                    node: {
                        HTMLclass: 'node',
                        collapsable: true, // ทำให้เส้นของ node สามารถย่อ-ขยายได้
                        drawLineThrough: false, // ไม่ให้เส้นของ node ดึงต่อกับ node ที่อยู่ด้านบน
                    },
                    viewportOverflow: false
                },
                nodeStructure: createNodeStructure(data[0])
            };
            if (data.length > 1) {
                let currentNode = treeData.nodeStructure;

                for (var i = 1; i < data.length; i++) {
                    var node = createNodeStructure(data[i]);
                    if (!currentNode.children) {
                        currentNode.children = [];
                    }
                    currentNode.children.push(node);
                    currentNode = currentNode.children[currentNode.children.length - 1];
                }
            }
            return treeData;
        }
        // สร้างต้นไม้
        $(document).ready(function() {
            position.push('-')
            base_stuc_po.forEach(element => {
                position.push(element['stpo_name']);
            });
            var simple_chart_config = createTreeData(data2);
            new Treant(simple_chart_config);
            personData.forEach(element => {
                var profilePicture = document.getElementById("profile_picture" + element.stdp_id);
                if (profilePicture) {
                    if (element.psd_picture != null) {
                        var profile_picture_url = `<?php echo site_url($this->config->item('hr_dir') . 'getIcon?type=' . $this->config->item('hr_profile_dir') . "profile_picture&image="); ?>${element.psd_picture}`;
                    } else {
                        var profile_picture_url = `<?php echo site_url($this->config->item('hr_dir') . 'getIcon?type=' . $this->config->item('hr_profile_dir') . "profile_picture&image=default.png") ?>`;
                    }
                    profilePicture.setAttribute("src", profile_picture_url);
                }
            });
        });
    </script>
</body>

</html>